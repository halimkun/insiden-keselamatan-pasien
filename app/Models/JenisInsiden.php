<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class JenisInsiden
 *
 * @property $id
 * @property $nama_jenis_insiden
 * @property $created_at
 * @property $updated_at
 *
 * @property Insiden[] $insidens
 * @package App
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
    protected $fillable = ['nama_jenis_insiden'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'jenis_insiden_id');
    }
    
}
