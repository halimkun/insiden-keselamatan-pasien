<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tindakan
 *
 * @property $id
 * @property $deskripsi_tindakan
 * @property $created_at
 * @property $updated_at
 *
 * @property Insiden[] $insidens
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tindakan extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['deskripsi_tindakan'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'tindakan_id');
    }
    
}
