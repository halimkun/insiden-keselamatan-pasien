<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JenisInsiden
 *
 * @property $id
 * @property $nama_jenis_insiden
 * @property $created_at
 * @property $updated_at
 * @property Insiden[] $insidens
 * @package App
 * @property string $alias
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read int|null $insidens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereAlias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereNamaJenisInsiden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|JenisInsiden withoutTrashed()
 * @mixin \Eloquent
 */
class JenisInsiden extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "jenis_insiden";

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array<int, string>
     */
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['alias', 'nama_jenis_insiden'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'jenis_insiden_id');
    }
}
