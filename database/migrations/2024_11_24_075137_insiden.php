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
        Schema::create('insiden', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pasien_id')->nullable()->constrained('pasien');
            $table->foreignId('jenis_insiden_id')->constrained('jenis_insiden');
            $table->date('tanggal_insiden');
            $table->time('waktu_insiden');
            $table->string('kronologi');
            $table->foreignId('unit_id')->constrained('unit');
            $table->foreignId('pelapor_id')->constrained('pelapor');
            $table->string('tempat_kejadian');
            $table->foreignId('akibat_id')->constrained('akibat');
            $table->foreignId('tindakan_id')->constrained('tindakan');
            $table->enum('grading_risiko', ['Biru', 'Hijau', 'Kuning', 'Merah']); // Input manually
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insiden');
    }
};
