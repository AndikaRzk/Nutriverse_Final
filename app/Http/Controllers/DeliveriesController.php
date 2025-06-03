<?php

namespace App\Http\Controllers;

use App\Models\Deliveries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveriesController extends Controller
{
    /**
     * Tampilkan ringkasan pengiriman milik kurir yang sedang login
     */
    public function index()
    {
        $courierId = Auth::guard('couriers')->id();; // Asumsikan kurir login sebagai user
        $deliveries = Deliveries::with(['order'])
                        ->where('courier_id', $courierId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('courier.orders', compact('deliveries'));
    }

    /**
     * Tampilkan detail lengkap dari sebuah pengiriman
     */
    public function show($id)
    {
        $delivery = Deliveries::with(['order.customer', 'order'])
                            ->findOrFail($id);

        // Opsional: Cek agar kurir hanya bisa akses miliknya
        if ($delivery->courier_id !== Auth::guard('couriers')->id()) {
            abort(403, 'Unauthorized');
        }

        return view('courier.detail', compact('delivery'));
    }

    /**
     * Update data pengiriman oleh kurir
     */
    // public function update(Request $request, $id)
    // {
    //     $delivery = Deliveries::findOrFail($id);

    //     if ($delivery->courier_id !== Auth::guard('couriers')->id()) {
    //         abort(403, 'Unauthorized');
    //     }

    //     $validated = $request->validate([
    //         'delivery_status' => 'required|in:assigned,picking_up,on_the_way,delivered,failed',
    //         'pickup_at' => 'nullable|date',
    //         'delivered_at' => 'nullable|date',
    //         'delivery_notes' => 'nullable|string',
    //         'proof_of_delivery_image' => 'nullable|image|max:2048',
    //     ]);

    //     // Handle upload jika ada bukti pengiriman
    //     if ($request->hasFile('proof_of_delivery_image')) {
    //         $path = $request->file('proof_of_delivery_image')->store('delivery_proofs', 'public');
    //         $validated['proof_of_delivery_image'] = $path;
    //     }

    //     $delivery->update($validated);

    //     return redirect()->route('courier.deliveries.show', $id)
    //                      ->with('success', 'Pengiriman berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
{
    $delivery = Deliveries::findOrFail($id);

    if ($delivery->courier_id !== Auth::guard('couriers')->id()) {
        abort(403, 'Unauthorized');
    }

    $validated = $request->validate([
        'delivery_status' => 'required|in:assigned,picking_up,on_the_way,delivered,failed',
        'pickup_at' => 'nullable|date',
        'delivered_at' => 'nullable|date',
        'delivery_notes' => 'nullable|string',
        'proof_of_delivery_image' => 'nullable|image|max:2048',
    ]);

    // Handle upload jika ada bukti pengiriman
    if ($request->hasFile('proof_of_delivery_image')) {
        $file = $request->file('proof_of_delivery_image');
        $timestamp = now()->format('Y-m-d_H-i-s'); // Contoh: 2025-06-03_14-30-55
        $filename = 'delivery_' . $delivery->id . '_' . $timestamp . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('delivery_proofs', $filename, 'public');
        $validated['proof_of_delivery_image'] = $path;
    }

    $delivery->update($validated);

    return redirect()->route('courier.deliveries.show', $id)
                     ->with('success', 'Delivery successfully updated.');
}


}
