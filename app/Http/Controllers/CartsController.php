<?php

namespace App\Http\Controllers;

use App\Models\CartItems;
use App\Models\Carts;
use App\Models\Orders;
use App\Models\Supplement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'supplement_id' => 'required|exists:supplements,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // Anggap customer sudah login (pakai Auth)
        $customer = Auth::guard('customers')->user();

        // Cek apakah customer sudah punya keranjang
        $cart = Carts::firstOrCreate([
            'customer_id' => $customer->id
        ]);

        // Cek apakah suplemen sudah ada di keranjang
        $cartItem = CartItems::where('cart_id', $cart->id)
                            ->where('supplement_id', $request->supplement_id)
                            ->first();

        if ($cartItem) {
            // Jika sudah ada, tambahkan jumlahnya
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Jika belum ada, buat item baru
            CartItems::create([
                'cart_id' => $cart->id,
                'supplement_id' => $request->supplement_id,
                'quantity' => $request->quantity
            ]);
        }

        return redirect()->back()->with('success', 'Suplemen berhasil ditambahkan ke keranjang.');
    }

    public function updateQuantity(Request $request)
    {
        // Validate the entire quantities array
        $request->validate([
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:0', // Each quantity must be integer and >= 0
        ]);

        $customer = Auth::guard('customers')->user();

        if (!$customer) {
            return redirect()->back()->with('error', 'Anda harus login untuk memperbarui keranjang.');
        }

        $cart = Carts::where('customer_id', $customer->id)->first();

        if (!$cart) {
            return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
        }

        $updatedCount = 0;
        $deletedCount = 0;

        foreach ($request->quantities as $supplementId => $newQuantity) {
            $cartItem = CartItems::where('cart_id', $cart->id)
                                 ->where('supplement_id', $supplementId)
                                 ->first();

            if ($cartItem) {
                if ($newQuantity == 0) {
                    // If new quantity is 0, delete the item
                    $cartItem->delete();
                    $deletedCount++;
                } else {
                    // Otherwise, update the quantity
                    $cartItem->quantity = $newQuantity;
                    $cartItem->save();
                    $updatedCount++;
                }
            }
            // If cartItem is not found, it means the supplement_id was tampered with or item was removed
            // No action needed, or you could log it.
        }

        $message = [];
        if ($updatedCount > 0) {
            $message[] = "$updatedCount item diperbarui.";
        }
        if ($deletedCount > 0) {
            $message[] = "$deletedCount item dihapus.";
        }

        if (empty($message)) {
            return redirect()->back()->with('info', 'Tidak ada perubahan pada keranjang.');
        }

        return redirect()->back()->with('success', implode(' dan ', $message) . ' Keranjang berhasil diperbarui.');
    }

    public function remove(Request $request)
{
    $request->validate([
        'supplement_id' => 'required|exists:supplements,id',
    ]);

    $customer = Auth::guard('customers')->user();

    if (!$customer) {
        return redirect()->back()->with('error', 'Anda harus login untuk menghapus item.');
    }

    $cart = Carts::where('customer_id', $customer->id)->first();

    if (!$cart) {
        return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
    }

    $cartItem = CartItems::where('cart_id', $cart->id)
                         ->where('supplement_id', $request->supplement_id)
                         ->first();

    if ($cartItem) {
        $cartItem->delete();

        $remainingItems = CartItems::where('cart_id', $cart->id)->count();

        return redirect()->route('cart.index')->with('success', $remainingItems === 0
            ? 'Item dihapus. Keranjang sekarang kosong.'
            : 'Item berhasil dihapus dari keranjang.');
    }

    return redirect()->back()->with('error', 'Item tidak ditemukan dalam keranjang.');
}

    public function index()
    {
        $customer = Auth::guard('customers')->user();

        if (!$customer) {
            // Redirect to login or show empty cart if not logged in
            return redirect()->route('customer.login')->with('info', 'Silakan login untuk melihat keranjang Anda.');
        }

        $cart = Carts::where('customer_id', $customer->id)->first();

        $cartItems = collect(); // Default to an empty collection

        if ($cart) {
            $cartItems = CartItems::where('cart_id', $cart->id)
                                  ->with('supplement') // Eager load the supplement relationship
                                  ->get();
        }

        return view('customer.carts', compact('cartItems'));
    }

    public function confirmPayment(Orders $order)
    {
        $order->load('orderItems.supplement');

        return view('customers.confirm', compact('order'));
    }


}
