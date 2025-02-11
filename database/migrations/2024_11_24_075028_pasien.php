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
        Schema::create('pasien', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik')->unique()->nullable()->default(null)->comment('Nomor Induk Kependudukan');
            $table->foreignId('penanggung_biaya_id')->nullable()->constrained('penanggung_biaya');
            $table->string('no_rekam_medis')->unique();
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_telp')->nullable();
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();

            // $table->foreignId('penanggung_biaya_id')->constrained('penanggung_biaya');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasien');
    }
};
