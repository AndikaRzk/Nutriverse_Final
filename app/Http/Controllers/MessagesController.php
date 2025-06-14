<?php

namespace App\Http\Controllers;

use App\Models\Chats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    /**
     * Menampilkan daftar chat yang dimiliki konsultan yang sedang login.
     */
    public function indexChats()
    {
        // Dapatkan konsultan yang sedang login
        $consultant = Auth::guard('consultants')->user(); // Sesuaikan guard Anda
        $consultantId = $consultant->id;
        // Ambil semua chat yang melibatkan konsultan ini, dan muat data customer
        // Urutkan berdasarkan waktu update terbaru agar chat yang aktif muncul di atas
        $chats = Chats::where('consultant_id', $consultantId)
                      ->with('customer') // Memuat relasi customer
                      ->orderBy('updated_at', 'desc') // Urutkan berdasarkan waktu update chat
                      ->get();

        return view('consultant.chats.index', compact('chats'));
    }

    /**
     * Menampilkan halaman chat untuk percakapan tertentu (dari sisi konsultan).
     */
    public function showChat(Chats $chat)
    {
        // Pastikan chat ini benar-benar milik konsultan yang sedang login
        if (!Auth::guard('consultants')->check() || $chat->consultant_id !== Auth::guard('consultants')->id()) {
            return redirect()->route('consultant.chats.index')->with('error', 'Anda tidak memiliki akses ke chat ini.');
        }

        // Load pesan-pesan dalam chat, diurutkan dari yang paling lama
        $messages = $chat->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return view('consultant.chats.show', compact('chat', 'messages'));
    }

    /**
     * Menyimpan pesan baru ke dalam chat (dari sisi konsultan).
     */
    public function sendMessage(Request $request, Chats $chat)
    {
        $request->validate([
            'message' => 'nullable|string|max:2000',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        if (!Auth::guard('consultants')->check() || $chat->consultant_id !== Auth::guard('consultants')->id()) {
            return back()->with('error', 'Anda tidak diizinkan mengirim pesan di chat ini.');
        }

        $consultant = Auth::guard('consultants')->user();
        $filePath = null;
        $fileType = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $fileName = strtoupper(uniqid()) . '_' . time() . '.' . $extension;
            $filePath = $file->storeAs('public/chat_files', $fileName);
            $fileType = 'image';
        }

        $message = $chat->messages()->create([
            'sender_id' => $consultant->id,
            'sender_type' => get_class($consultant), // Akan jadi 'App\\Models\\Consultant'
            'message' => $request->input('message'),
            'file_path' => $filePath,
            'file_type' => $fileType,
            'read_at' => null, // Belum dibaca oleh penerima
        ]);

        // Opsional: Update updated_at di tabel chat agar chat ini naik ke atas daftar
        $chat->touch(); // Memperbarui timestamp updated_at pada model Chat

        return back();
    }
}
