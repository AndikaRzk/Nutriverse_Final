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
        Schema::create('forums', function (Blueprint $table) {
            $table->bigIncrements('ForumID');
            $table->timestamps();
            $table->string('ForumTitle');
            $table->longText('ForumContent');
            $table->primary('ForumID');
            $table->string('ForumImage')->nullable();
            $table->bigInteger('ForumCreator')->unsigned();
            $table->foreign('ForumCreator')->references('id')->on('customers')->onDelete('cascade');
            $table->date('CreatedAt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forums');
    }
};
