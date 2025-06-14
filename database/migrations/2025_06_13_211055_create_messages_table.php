<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id(); // Kunci utama untuk setiap pesan
            $table->foreignId('chat_id')->constrained('chats')->onDelete('cascade');
            $table->foreignId('sender_id'); // ID pengirim (bisa customer_id atau consultant_id)
            $table->string('sender_type'); // Tipe pengirim ('App\Models\Customer' atau 'App\Models\Consultant')
            $table->text('message')->nullable(); // Konten pesan teks. `nullable()` karena pesan bisa hanya berupa foto.
            $table->string('file_path')->nullable(); // Path/lokasi file foto atau media lain yang diunggah. `nullable()` jika pesan hanya teks.
            $table->string('file_type')->nullable(); // Tipe file yang diunggah (misal: 'image', 'video', 'document'). `nullable()` jika pesan hanya teks.
            $table->timestamp('read_at')->nullable(); // Timestamp kapan pesan dibaca oleh penerima
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
