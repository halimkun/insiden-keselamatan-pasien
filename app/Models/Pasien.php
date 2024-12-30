<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Pasien
 *
 * @property $id
 * @property $nama
 * @property $no_rekam_medis
 * @property $tanggal_lahir
 * @property $jenis_kelamin
 * @property $alamat
 * @property $penanggung_biaya_id
 * @property $created_at
 * @property $updated_at
 * @property PenanggungBiaya $penanggungBiaya
 * @property Insiden[] $insidens
 * @package App
 * @property string|null $nik Nomor Induk Kependudukan
 * @property string $tempat_lahir
 * @property string|null $no_telp
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $insidens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereAlamat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereJenisKelamin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNoRekamMedis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereNoTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereTanggalLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereTempatLahir($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pasien withoutTrashed()
 * @mixin \Eloquent
 */
class Pasien extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The "paginate" attribute of the model.
     *
     * @var int
     */
    protected $perPage = 20;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pasien';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'no_rekam_medis',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'nik',
        'tempat_lahir',
        'no_telp',
        'email',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function penanggungBiaya()
    {
        return $this->belongsTo(\App\Models\PenanggungBiaya::class, 'penanggung_biaya_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'pasien_id');
    }
}
