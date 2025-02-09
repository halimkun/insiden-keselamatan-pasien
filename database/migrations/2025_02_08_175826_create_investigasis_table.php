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
        Schema::create('investigasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('insiden_id')->constrained('insiden')->onDelete('cascade');
            $table->foreignId('grading_id')->nullable()->constrained('grading')->onDelete('set null');

            $table->text('penyebab_langsung')->nullable();
            $table->text('penyebab_awal')->nullable();
        
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->date('tanggal_pengesahan')->nullable();

            $table->boolean('lengkap')->default(false);
            $table->boolean('lanjutan')->default(false);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investigasi');
    }
};
