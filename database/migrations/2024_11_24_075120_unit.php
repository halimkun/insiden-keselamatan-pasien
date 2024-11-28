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
        Schema::create('unit', function (Blueprint $table) {
            $table->id();
            $table->string('nama_unit');
            $table->timestamps();
            $table->softDeletes();
        });

        // alter to karyawan table
        Schema::table('user_detail', function (Blueprint $table) {
            $table->foreignId('unit_id')->after('jabatan')->constrained('unit')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit');
    }
};
