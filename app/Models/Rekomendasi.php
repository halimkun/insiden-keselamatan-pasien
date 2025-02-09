<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Rekomendasi
 *
 * @property $id
 * @property $investigasi_id
 * @property $rekomendasi
 * @property $pj
 * @property $jangka_waktu
 * @property $batas_waktu
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 *
 * @property Investigasi $investigasi
 * @property User $user
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
class Rekomendasi extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    protected $table = 'rekomendasi';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['investigasi_id', 'rekomendasi', 'pj', 'jangka_waktu', 'batas_waktu'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function investigasi()
    {
        return $this->belongsTo(\App\Models\Investigasi::class, 'investigasi_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'pj', 'id');
    }
    
}
