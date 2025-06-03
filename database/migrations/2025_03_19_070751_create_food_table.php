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
        Schema::create('food', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama makanan
            $table->string('category'); // protein, karbo, sayur, buah, dll
            $table->enum('meal_time', ['breakfast', 'lunch', 'dinner']); // jenis jam makan
            $table->enum('bmi_category', ['underweight', 'normal', 'overweight', 'obese']); // target BMI
            $table->integer('portion_size_grams'); // ukuran porsi dalam gram
            $table->integer('calories'); // kalori per porsi
            $table->float('protein_g'); // kandungan protein (gram)
            $table->float('carbs_g'); // kandungan karbohidrat (gram)
            $table->float('fat_g'); // kandungan lemak (gram)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food');
    }
};
