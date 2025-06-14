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
    // public function add(Request $request)
    // {
    //     $customer = Auth::user(); // Dapatkan objek customer yang sedang login
    //     $supplementId = $request->input('supplement_id');
    //     $quantity = $request->input('quantity', 1); // Default quantity adalah 1 jika tidak disediakan

    //     // Validasi input
    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     // Cari suplemen yang ingin ditambahkan
    //     $supplement = Supplement::find($supplementId);

    //     // Periksa stok
    //     if ($supplement->stock < $quantity) {
    //         return back()->with('error', 'Stok ' . $supplement->name . ' tidak mencukupi. Stok tersedia: ' . $supplement->stock);
    //     }

    //     // Dapatkan keranjang belanja pelanggan yang sedang login
    //     // Jika belum ada, buat keranjang baru untuk pelanggan ini
    //     $cart = Carts::firstOrCreate(
    //         ['customer_id' => $customer->id],
    //         [] // Tidak ada atribut lain yang perlu diisi saat pembuatan pertama
    //     );

    //     // Cari apakah suplemen ini sudah ada di keranjang
    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                         ->where('supplement_id', $supplementId)
    //                         ->first();

    //     if ($cartItem) {
    //         // Jika sudah ada, update kuantitasnya
    //         $newQuantity = $cartItem->quantity + $quantity;
    //         if ($supplement->stock < $newQuantity) {
    //              return back()->with('error', 'Penambahan ini melebihi stok yang tersedia. Stok tersedia: ' . $supplement->stock);
    //         }
    //         $cartItem->quantity = $newQuantity;
    //         $cartItem->save();
    //     } else {
    //         // Jika belum ada, buat item keranjang baru
    //         CartItems::create([
    //             'cart_id' => $cart->id,
    //             'supplement_id' => $supplementId,
    //             'quantity' => $quantity,
    //         ]);
    //     }

    //     // Kurangi stok suplemen (penting untuk menjaga konsistensi stok real-time)
    //     // Catatan: Anda mungkin ingin memindahkan pengurangan stok ini ke tahap checkout/pembayaran
    //     // untuk menghindari masalah stok jika pelanggan tidak jadi checkout.
    //     // Tapi untuk kebutuhan 'add to cart' yang langsung mengurangi stok, ini bisa dilakukan.
    //     $supplement->stock -= $quantity;
    //     $supplement->save();

    //     return back()->with('success', $supplement->name . ' berhasil ditambahkan ke keranjang!');
    // }

     /**
     * Tambahkan suplemen ke keranjang belanja.
     */
    // public function add(Request $request)
    // {
    //     $customer = Auth::user(); // Dapatkan objek customer yang sedang login
    //     $supplementId = $request->input('supplement_id');
    //     $quantity = $request->input('quantity', 1); // Default quantity adalah 1 jika tidak disediakan

    //     // Validasi input
    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     // Cari suplemen yang ingin ditambahkan
    //     $supplement = Supplement::find($supplementId);

    //     // Periksa stok yang tersedia vs. kuantitas yang diminta
    //     if ($supplement->stock < $quantity) {
    //         return back()->with('error', 'Stok ' . $supplement->name . ' tidak mencukupi untuk penambahan ini. Stok tersedia: ' . $supplement->stock);
    //     }

    //     // Dapatkan keranjang belanja pelanggan yang sedang login
    //     // Jika belum ada, buat keranjang baru untuk pelanggan ini
    //     $cart = Carts::firstOrCreate(
    //         ['customer_id' => $customer->id],
    //         []
    //     );

    //     // Cari apakah suplemen ini sudah ada di keranjang pelanggan
    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                         ->where('supplement_id', $supplementId)
    //                         ->first();

    //     if ($cartItem) {
    //         // Jika sudah ada, update kuantitasnya
    //         $newQuantityInCart = $cartItem->quantity + $quantity;

    //         // Periksa lagi stok total setelah penambahan ke keranjang
    //         if ($supplement->stock < $newQuantityInCart) {
    //             return back()->with('error', 'Jumlah total ' . $supplement->name . ' di keranjang Anda melebihi stok yang tersedia. Stok tersedia: ' . $supplement->stock);
    //         }

    //         $cartItem->quantity = $newQuantityInCart;
    //         $cartItem->save();
    //     } else {
    //         // Jika belum ada, buat item keranjang baru
    //         CartItems::create([
    //             'cart_id' => $cart->id,
    //             'supplement_id' => $supplementId,
    //             'quantity' => $quantity,
    //         ]);
    //     }

    //     // Stok suplemen TIDAK DIKURANGI di sini.
    //     // Pengurangan stok akan dilakukan setelah pesanan dibayar.

    //     return back()->with('success', $supplement->name . ' berhasil ditambahkan ke keranjang!');
    // }

    // public function add(Request $request)
    // {
    //     // *** PERBAIKAN DI SINI ***
    //     // Dapatkan ID customer yang sedang login. Ini akan mengembalikan INTEGER.
    //     $customerId = Auth::id();

    //     // Penting: Pastikan pengguna sudah login sebelum ini!
    //     // Jika tidak ada yang login, Auth::id() akan mengembalikan null,
    //     // yang akan menyebabkan error 'Attempt to read property id on null' di Carts::firstOrCreate
    //     // jika 'customer_id' tidak bisa menerima null.
    //     // Sebaiknya, selalu ada cek Auth::check() sebelumnya atau gunakan middleware 'auth'.
    //     // if (!Auth::check()) {
    //     //     return redirect()->route('login')->with('error', 'Anda harus login untuk menambahkan item ke keranjang.');
    //     // }

    //     $supplementId = $request->input('supplement_id');
    //     $quantity = $request->input('quantity', 1);

    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //         'quantity' => 'required|integer|min:1',
    //     ]);

    //     $supplement = Supplement::find($supplementId);

    //     if (!$supplement) {
    //         return back()->with('error', 'Suplemen tidak ditemukan.');
    //     }

    //     if ($supplement->stock < $quantity) {
    //         return back()->with('error', 'Stok ' . $supplement->name . ' tidak mencukupi untuk penambahan ini. Stok tersedia: ' . $supplement->stock);
    //     }

    //     // *** PERBAIKAN DI SINI ***
    //     // Langsung gunakan $customerId yang sudah berisi ID integer
    //     $cart = Carts::firstOrCreate( // Pastikan nama model Anda 'Cart' (singular), bukan 'Carts' (plural)
    //         ['customer_id' => $customerId],
    //         []
    //     );

    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                         ->where('supplement_id', $supplementId)
    //                         ->first();

    //     if ($cartItem) {
    //         $newQuantityInCart = $cartItem->quantity + $quantity;
    //         if ($supplement->stock < $newQuantityInCart) {
    //             return back()->with('error', 'Jumlah total ' . $supplement->name . ' di keranjang Anda melebihi stok yang tersedia. Stok tersedia: ' . $supplement->stock);
    //         }
    //         $cartItem->quantity = $newQuantityInCart;
    //         $cartItem->save();
    //     } else {
    //         CartItems::create([
    //             'cart_id' => $cart->id,
    //             'supplement_id' => $supplementId,
    //             'quantity' => $quantity,
    //         ]);
    //     }

    //     return back()->with('success', $supplement->name . ' berhasil ditambahkan ke keranjang!');
    // }

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


    // public function updateQuantity(Request $request)
    // {
    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //         'quantity' => 'required|integer|min:0'
    //     ]);

    //     $customer = Auth::guard('customers')->user();

    //     $cart = Carts::where('customer_id', $customer->id)->first();

    //     if (!$cart) {
    //         return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
    //     }

    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                         ->where('supplement_id', $request->supplement_id)
    //                         ->first();

    //     if (!$cartItem) {
    //         return redirect()->back()->with('error', 'Item tidak ditemukan dalam keranjang.');
    //     }

    //     if ($request->quantity == 0) {
    //         $cartItem->delete();
    //         return redirect()->back()->with('success', 'Item dihapus dari keranjang.');
    //     } else {
    //         $cartItem->quantity = $request->quantity;
    //         $cartItem->save();
    //         return redirect()->back()->with('success', 'Quantity berhasil diperbarui.');
    //     }
    // }

    // public function remove(Request $request)
    // {
    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //     ]);

    //     $customer = Auth::guard('customers')->user();

    //     $cart = Carts::where('customer_id', $customer->id)->first();

    //     if (!$cart) {
    //         return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
    //     }

    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                         ->where('supplement_id', $request->supplement_id)
    //                         ->first();

    //     if ($cartItem) {
    //         $cartItem->delete();
    //         return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    //     }

    //     return redirect()->back()->with('error', 'Item tidak ditemukan.');
    // }

    // asli
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

    // asli
    // public function remove(Request $request)
    // {
    //     $request->validate([
    //         'supplement_id' => 'required|exists:supplements,id',
    //     ]);

    //     $customer = Auth::guard('customers')->user();

    //     if (!$customer) {
    //         return redirect()->back()->with('error', 'Anda harus login untuk menghapus item.');
    //     }

    //     $cart = Carts::where('customer_id', $customer->id)->first();

    //     if (!$cart) {
    //         return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
    //     }

    //     $cartItem = CartItems::where('cart_id', $cart->id)
    //                          ->where('supplement_id', $request->supplement_id)
    //                          ->first();

    //     if ($cartItem) {
    //         $cartItem->delete();
    //         return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
    //     }

    //     return redirect()->back()->with('error', 'Item tidak ditemukan dalam keranjang.');
    // }

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


//     public function remove(Request $request)
// {
//     $request->validate([
//         'supplement_id' => 'required|exists:supplements,id',
//     ]);

//     $customer = Auth::guard('customers')->user();

//     if (!$customer) {
//         return redirect()->back()->with('error', 'Anda harus login untuk menghapus item.');
//     }

//     $cart = Carts::where('customer_id', $customer->id)->first();

//     if (!$cart) {
//         return redirect()->back()->with('error', 'Keranjang tidak ditemukan.');
//     }

//     $cartItem = CartItems::where('cart_id', $cart->id)
//                          ->where('supplement_id', $request->supplement_id)
//                          ->first();

//     if ($cartItem) {
//         $cartItem->delete();

//         // Cek apakah ada item tersisa
//         $remainingItems = CartItems::where('cart_id', $cart->id)->count();

//         if ($remainingItems === 0) {
//             // Optional: jika ingin hapus cart juga
//             // $cart->delete();
//             return redirect()->route('cart.index')->with('success', 'Item dihapus. Keranjang sekarang kosong.');
//         }

//         return redirect()->back()->with('success', 'Item berhasil dihapus dari keranjang.');
//     }

//     return redirect()->back()->with('error', 'Item tidak ditemukan dalam keranjang.');
// }


    // You might also have a function to display the cart, e.g.:
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
