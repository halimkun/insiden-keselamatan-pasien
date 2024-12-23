<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tindakan
 *
 * @property $id
 * @property $tindakan
 * @property $oleh
 * @property $detail
 * @property $created_at
 * @property $updated_at
 * @property Insiden[] $insidens
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @property-read int|null $insidens_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tindakan query()
 * @mixin \Eloquent
 */
class Tindakan extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tindakan', 'oleh', 'detail'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'tindakan_id');
    }
    
}
