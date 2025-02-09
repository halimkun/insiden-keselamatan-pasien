<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Investigasi
 *
 * @property $id
 * @property $insiden_id
 * @property $penyebab_langsung
 * @property $penyebab_awal
 * @property $tanggal_mulai
 * @property $tanggal_selesai
 * @property $tanggal_pengesahan
 * @property $lengkap
 * @property $lanjutan
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Insiden $insiden
 * @property Rekomendasi[] $rekomendasis
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read int|null $insidens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Grading withoutTrashed()
 * @mixin \Eloquent
 */
class Investigasi extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    protected $table = 'investigasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['insiden_id', 'grading_id', 'penyebab_langsung', 'penyebab_awal', 'tanggal_mulai', 'tanggal_selesai', 'tanggal_pengesahan', 'lengkap', 'lanjutan'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insiden()
    {
        return $this->belongsTo(\App\Models\Insiden::class, 'insiden_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rekomendasi()
    {
        return $this->hasMany(\App\Models\Rekomendasi::class, 'investigasi_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function grading()
    {
        return $this->hasOne(\App\Models\Grading::class, 'id', 'grading_id');
    }
}
