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
            $table->string('insiden');
            $table->text('kronologi');
            $table->string('jenis_pelapor');
            $table->string('jenis_pelapor_lainnya')->nullable()->default(null);
            $table->string('korban_insiden');
            $table->string('korban_insiden_lainnya')->nullable()->default(null);
            $table->string('layanan_insiden');
            $table->string('layanan_insiden_lainnya')->nullable()->default(null);
            $table->string('kasus_insiden');
            $table->string('kasus_insiden_lainnya')->nullable()->default(null);
            $table->string('tempat_kejadian');
            $table->foreignId('unit_id')->constrained('unit');
            $table->string('dampak_insiden');
            $table->foreignId('tindakan_id')->nullable()->default(null)->constrained('tindakan');
            $table->tinyInteger('pernah_terjadi')->default(0);
            $table->string('status_pelapor');
            $table->enum('grading_risiko', ['Biru', 'Hijau', 'Kuning', 'Merah']); // Input manually
            
            // $table->foreignId('pelapor_id')->constrained('pelapor');
            $table->timestamps();
            $table->softDeletes();
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
