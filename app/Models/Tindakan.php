<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tindakan
 *
 * @property $id
 * @property $tindakan
 * @property $oleh
 * @property $created_at
 * @property $updated_at
 *
 * @property Insiden[] $insidens
 * @package App
 */
class Tindakan extends Model
{
    protected $table = 'tindakan';

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['tindakan', 'oleh'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'tindakan_id');
    }
    
}
