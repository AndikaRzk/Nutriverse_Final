<?php

namespace App\Http\Controllers;

use App\Models\Carts;
use App\Models\Courier;
use App\Models\Deliveries;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Illuminate\Support\Facades\Http;

class OrdersController extends Controller
{

    public function showorders(){
        $customer = Auth::guard('customers')->user();
        $cart = Carts::where('customer_id', $customer->id)->first();

        $cartItems = $cart ? $cart->cartItems()->with('supplement')->get() : collect();

        return view('customer.carts', compact('cartItems'));
    }

    public function store(Request $request)
{
    $customer = Auth::guard('customers')->user();
    $cart = Carts::where('customer_id', $customer->id)->with('cartItems.supplement')->first();

    if (!$cart || $cart->cartItems->isEmpty()) {
        return redirect()->back()->with('error', 'Keranjang kosong.');
    }

    $validated = $request->validate([
        'delivery_address' => 'required|string|max:255',
        'delivery_phone' => 'required|string|max:20',
        'notes' => 'nullable|string|max:500',
    ]);

    $subtotal = 0;
    $totalItems = 0;

    foreach ($cart->cartItems as $item) {
        $subtotal += $item->quantity * $item->supplement->price;
        $totalItems += $item->quantity;
    }

    $tax = $subtotal * 0.11;
    $shipping = 10000 + (floor(($totalItems - 1) / 5) * 5000);
    $courierCommission = $totalItems < 10 ? $shipping * 0.6 : $shipping * 0.5;
    $total = $subtotal + $tax + $shipping;

    $order = Orders::create([
        'customer_id' => $customer->id,
        'order_number' => 'ORD-' . strtoupper(uniqid()),
        'subtotal_amount' => $subtotal,
        'tax_amount' => $tax,
        'shipping_cost' => $shipping,
        'courier_commission_amount' => $courierCommission,
        'total_amount' => $total,
        'delivery_address' => $validated['delivery_address'],
        'delivery_phone' => $validated['delivery_phone'],
        'notes' => $validated['notes'] ?? null,
        'order_status' => 'pending',
        'payment_status' => 'pending',
        'courier_id' => null,
    ]);

    // ✅ Simpan order_items dari cart
    foreach ($cart->cartItems as $item) {
        \App\Models\OrderItems::create([
            'order_id' => $order->id,
            'supplement_id' => $item->supplement_id,
            'quantity' => $item->quantity,
            'price_at_purchase' => $item->supplement->price,
        ]);
    }

    // ✅ (Opsional) Kosongkan cart setelah checkout
    $cart->cartItems()->delete();

    return redirect()->route('payment.confirm', ['order' => $order->id]);
}

    public function index()
    {
        $customer = Auth::guard('customers')->user();

        // Ambil semua order milik customer, dengan relasi orderItems dan suplemen
        $orders = Orders::with('orderItems.supplement')
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('payment.orders', compact('orders'));
    }

    public function showconfirmPayment($id)
    {
        // Ambil data order beserta relasi customer
        $orders = Orders::with('customer')->findOrFail($id);

        // Siapkan parameter Midtrans untuk Snap token
        $params = [
            'transaction_details' => [
                'order_id' => $orders->order_number, // Nomor unik pesanan dari tabel orders
                'gross_amount' => (int) $orders->total_amount, // Total yang harus dibayar
            ],
            'customer_details' => [
                'first_name' => $orders->customer->name,
                'email' => $orders->customer->email,
                'phone' => $orders->delivery_phone, // atau $order->customer->phone jika tersedia
            ],
            'item_details' => [
                [
                    'id' => $orders->id,
                    'price' => (int) $orders->total_amount,
                    'quantity' => 1,
                    'name' => "Order {$orders->order_number}",
                ]
            ],
        ];

        try {
            // Generate Snap Token
            $snapToken = Snap::getSnapToken($params);

            // Logging token jika ingin debugging
            Log::info('Midtrans Snap Token:', ['snap_token' => $snapToken]);

            // Tampilkan halaman konfirmasi pembayaran (kamu bisa sesuaikan view-nya)
            return view('customer.confirm', compact('orders', 'snapToken'));
        } catch (\Exception $e) {
            Log::error('Gagal generate Midtrans Snap Token: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    public function processPaymentAndNotification(Request $request)
{
    try {
        $notificationBody = json_decode($request->getContent(), true);

        Log::info('Midtrans Notification:', ['body' => $notificationBody]);

        if (!isset($notificationBody['order_id'], $notificationBody['transaction_status'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid notification data'], 400);
        }

        $orderId = $notificationBody['order_id'];

        $order = Orders::where('order_number', $orderId)->first();
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        $serverKey = config('midtrans.server_key');
        if (!$serverKey) {
            return response()->json(['status' => 'error', 'message' => 'Midtrans server key not configured'], 500);
        }

        // Call Midtrans API
        $midtransResponse = Http::withBasicAuth($serverKey, '')
            ->timeout(10)
            ->get("https://api.sandbox.midtrans.com/v2/{$orderId}/status");

        if ($midtransResponse->failed()) {
            Log::error('Midtrans API failed', ['status' => $midtransResponse->status(), 'body' => $midtransResponse->body()]);
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve transaction status'], 500);
        }

        $midtransData = $midtransResponse->json();

        if (!isset($midtransData['transaction_status'])) {
            return response()->json(['status' => 'error', 'message' => 'Invalid Midtrans response'], 500);
        }

        $status = $midtransData['transaction_status'];
        $paymentRef = $midtransData['transaction_id'] ?? null;

        $statusMapping = [
            'settlement' => 'paid',
            'capture'    => 'paid',
            'pending'    => 'pending',
            'deny'       => 'failed',
            'cancel'     => 'failed',
            'expire'     => 'failed'
        ];

        $newStatus = $statusMapping[$status] ?? 'failed';

        if ($order->payment_status !== $newStatus) {
            $order->payment_status = $newStatus;
            $order->payment_gateway_ref = $paymentRef;

            if ($newStatus === 'paid') {
                $order->order_status = 'processing';

                $randomCourier = Courier::inRandomOrder()->first();
                if ($randomCourier) {
                    $order->courier_id = $randomCourier->id;
                    Deliveries::create([
                        'order_id' => $order->id,
                        'courier_id' => $randomCourier->id,
                        'delivery_status' => 'assigned',
                    ]);
                }
            }

            $order->save();
        }

        return response()->json(['status' => 'success']);
    } catch (\Exception $e) {
        Log::error('Exception in payment notification', ['error' => $e->getMessage()]);
        return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
    }
}

    public function summaryorders(Request $request)
    {
        $customerId = Auth::guard('customers')->id();
        $keyword = $request->input('search');
        $perPage = 9; // Define how many orders you want per page (e.g., 9 for 3x3 grid)

        $orders = Orders::where('customer_id', $customerId)
            ->when($keyword, function ($query, $keyword) {
                return $query->where('order_number', 'like', '%' . $keyword . '%');
            })
            ->latest() // Order by latest orders first
            ->paginate($perPage); // Change from get() to paginate()

        return view('orders.summary', compact('orders', 'keyword'));
    }

    public function summaryordersdetail(Orders $order)
{
    $customer = Auth::guard('customers')->user();

        // Cegah akses order milik customer lain
        if ($order->customer_id !== $customer->id) {
            abort(403);
        }

        $order->load(['orderItems.supplement', 'courier']);

        return view('orders.detail', compact('order'));

}

}
