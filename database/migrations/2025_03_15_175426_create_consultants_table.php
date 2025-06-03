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
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gender');
            $table->date('dob');
            $table->string('specialization'); // Area of expertise
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->unique();
            $table->integer('experience')->default(0); // Years of experience
            $table->decimal('price_per_session', 10, 2)->default(0); // Harga per sesi dalam mata uang
            $table->boolean('is_available')->default(true); // Apakah consultant menerima sesi baru?
            $table->time('available_from')->nullable(); // Jam mulai konsultasi
            $table->time('available_to')->nullable();   // Jam selesai konsultasi
            $table->boolean('is_online')->default(false); // Status online consultant
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultants');
    }
};
