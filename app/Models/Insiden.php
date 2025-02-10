<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
 * @property Akibat $akibat
 * @property JenisInsiden $jenisInsiden
 * @property Pasien $pasien
 * @property Pelapor $pelapor
 * @property Tindakan $tindakan
 * @property Unit $unit
 * @package App
 * @property \Illuminate\Support\Carbon $tgl_pasien_masuk
 * @property string $insiden
 * @property string $jenis_pelapor
 * @property string|null $jenis_pelapor_lainnya
 * @property string $korban_insiden
 * @property string|null $korban_insiden_lainnya
 * @property string $layanan_insiden
 * @property string|null $layanan_insiden_lainnya
 * @property string $kasus_insiden
 * @property string|null $kasus_insiden_lainnya
 * @property string $dampak_insiden
 * @property int $pernah_terjadi
 * @property string $status_pelapor
 * @property int|null $grading_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Grading|null $grading
 * @property-read \App\Models\JenisInsiden $jenis
 * @property-read \App\Models\User $oleh
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereDampakInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereGradingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisInsidenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisPelapor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereJenisPelaporLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKasusInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKasusInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKorbanInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKorbanInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereKronologi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereLayananInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereLayananInsidenLainnya($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden wherePasienId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden wherePernahTerjadi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereStatusPelapor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTanggalInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTempatKejadian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTglPasienMasuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereTindakanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden whereWaktuInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Insiden withoutTrashed()
 * @mixin \Eloquent
 */
class Insiden extends Model
{
    use SoftDeletes, HasFactory;

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
        'investigasi_sederhana',
        "grading_id",
        "created_by",
        "created_sign",
        "received_by",
        "received_sign",
        "received_at"
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_insiden'  => 'date',
        'tgl_pasien_masuk' => 'date',
        'received_at'      => 'datetime',
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
    public function jenis()
    {
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penerima()
    {
        return $this->belongsTo(\App\Models\User::class, 'received_by', 'id');
    }

    public function investigasi()
    {
        return $this->hasOne(\App\Models\Investigasi::class, 'insiden_id', 'id');
    }
}
