<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Insiden
 *
 * @property $id
 * @property $pasien_id
 * @property $jenis_insiden_id
 * @property $tanggal_insiden
 * @property $waktu_insiden
 * @property $kronologi
 * @property $unit_id
 * @property $pelapor_id
 * @property $tempat_kejadian
 * @property $akibat_id
 * @property $tindakan_id
 * @property $grading_risiko
 * @property $created_at
 * @property $updated_at
 *
 * @property Akibat $akibat
 * @property JenisInsiden $jenisInsiden
 * @property Pasien $pasien
 * @property Pelapor $pelapor
 * @property Tindakan $tindakan
 * @property Unit $unit
 * @package App
 */
class Insiden extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $perPage = 20;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "insiden";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        "pasien_id",
        'tgl_pasien_masuk',
        "jenis_insiden_id",
        "tanggal_insiden",
        "waktu_insiden",
        "insiden",
        "kronologi",
        "jenis_pelapor",
        "jenis_pelapor_lainnya",
        "korban_insiden",
        "korban_insiden_lainnya",
        "layanan_insiden",
        "layanan_insiden_lainnya",
        "kasus_insiden",
        "kasus_insiden_lainnya",
        "tempat_kejadian",
        "unit_id",
        "dampak_insiden",
        "tindakan_id",
        "oleh",
        "oleh_tim",
        "oleh_petugas",
        "pernah_terjadi",
        "status_pelapor",
        "grading_id",
        "created_by",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_insiden' => 'date',
        'tgl_pasien_masuk' => 'date',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenisInsiden()
    {
        return $this->belongsTo(\App\Models\JenisInsiden::class, 'jenis_insiden_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function jenis() {
        return $this->belongsTo(\App\Models\JenisInsiden::class, 'jenis_insiden_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasien()
    {
        return $this->belongsTo(\App\Models\Pasien::class, 'pasien_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tindakan()
    {
        return $this->belongsTo(\App\Models\Tindakan::class, 'tindakan_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(\App\Models\Unit::class, 'unit_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grading()
    {
        return $this->belongsTo(\App\Models\Grading::class, 'grading_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function oleh()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }
}
