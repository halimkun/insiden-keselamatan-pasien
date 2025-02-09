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
        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investigasi_id')->constrained('investigasi')->onDelete('cascade');
            $table->text('rekomendasi');
            $table->foreignId('pj')->constrained('users')->onDelete('cascade');
            $table->enum('jangka_waktu', ['pendek', 'menengah', 'panjang']);
            $table->date('batas_waktu');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
