<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PenanggungBiaya
 *
 * @property $id
 * @property $jenis_penanggung
 * @property $created_at
 * @property $updated_at
 * @property Pasien[] $pasiens
 * @package App
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $pasiens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereJenisPenanggung($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PenanggungBiaya withoutTrashed()
 * @mixin \Eloquent
 */
class PenanggungBiaya extends Model
{
    use SoftDeletes;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "penanggung_biaya";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['jenis_penanggung'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pasiens()
    {
        return $this->hasMany(\App\Models\Pasien::class, 'id', 'penanggung_biaya_id');
    }
    
}
