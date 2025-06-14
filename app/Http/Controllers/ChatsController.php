<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use App\Models\Consultant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatsController extends Controller
{

     /**
     * Menampilkan daftar semua konsultan.
     */
    public function indexConsultants()
    {
        // Ambil semua konsultan dari database
        // Anda bisa tambahkan filter atau paginasi di sini jika daftar konsultan banyak
        $consultants = Consultant::all();

        return view('customer.chats.index', compact('consultants'));
    }

    /**
     * Membuat atau menemukan chat dengan konsultan dan mengarahkannya.
     */
    public function startChat(Consultant $consultant)
    {
        // Pastikan customer sudah login
        if (!Auth::guard('customers')->check()) { // Sesuaikan guard jika Anda punya guard 'customer'
            return redirect()->route('customer.login')->with('error', 'Silakan login terlebih dahulu untuk memulai chat.');
        }

        $customer = Auth::guard('customers')->user(); // Dapatkan data customer yang sedang login

        // Cari apakah sudah ada chat antara customer ini dan konsultan ini
        $chat = Chats::where('customer_id', $customer->id)
                    ->where('consultant_id', $consultant->id)
                    ->first();

        // Jika belum ada, buat chat baru
        if (!$chat) {
            $chat = Chats::create([
                'customer_id' => $customer->id,
                'consultant_id' => $consultant->id,
            ]);
        }

        // Redirect ke halaman chat dengan ID chat
        return redirect()->route('customer.chat.show', $chat->id);
    }

     /**
     * Menampilkan halaman chat untuk percakapan tertentu.
     */
    public function showChat(Chats $chat) // Laravel akan otomatis menginject model Chat berdasarkan ID di URL
    {
        // Pastikan chat ini benar-benar milik customer yang sedang login
        if (!Auth::guard('customers')->check() || $chat->customer_id !== Auth::guard('customers')->id()) {
            return redirect()->route('customer.consultants.index')->with('error', 'Anda tidak memiliki akses ke chat ini.');
        }

        // Load pesan-pesan dalam chat, diurutkan dari yang paling lama
        // Anda bisa tambahkan paginasi di sini jika pesannya sangat banyak
        $messages = $chat->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return view('customer.chats.show', compact('chat', 'messages'));
    }


    /**
     * Menyimpan pesan baru ke dalam chat.
     */
    public function sendMessage(Request $request, Chats $chat)
    {
        // Validasi input
        $request->validate([
            'message' => 'nullable|string|max:2000',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Pastikan customer sudah login dan chat ini miliknya
        if (!Auth::guard('customers')->check() || $chat->customer_id !== Auth::guard('customers')->id()) {
            return back()->with('error', 'Anda tidak diizinkan mengirim pesan di chat ini.');
        }

        $customer = Auth::guard('customers')->user();
        $filePath = null;
        $fileType = null;

        // Tangani upload file jika ada
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Dapatkan ekstensi asli dari file
            $extension = $file->getClientOriginalExtension();

            // Buat nama file unik dengan uniqid(), uppercase, dan timestamp
            // uniqid() menghasilkan string berdasarkan waktu saat ini dalam mikrodetik
            // time() menambahkan timestamp Unix saat ini (detik)
            $fileName = strtoupper(uniqid()) . '_' . time() . '.' . $extension;

            // Simpan file di storage/app/public/chat_files dengan nama yang baru
            $filePath = $file->storeAs('public/chat_files', $fileName);

            $fileType = 'image'; // Tetap seperti ini, atau tambahkan logika deteksi jenis file yang lebih canggih
        }

        // Buat pesan baru
        $message = $chat->messages()->create([
            'sender_id' => $customer->id,
            'sender_type' => get_class($customer), // atau 'App\\Models\\Customer'
            'message' => $request->input('message'),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'read_at' => null, // Belum dibaca oleh penerima
        ]);

        // Redirect kembali ke halaman chat
        return back(); // Redirect kembali ke halaman sebelumnya (halaman chat)
    }

}
