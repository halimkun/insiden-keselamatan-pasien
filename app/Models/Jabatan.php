<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Jabatan
 *
 * @property $id
 * @property $kode
 * @property $nama
 * @property $deskripsi
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Eloquent
 */
class Jabatan extends Model
{
    
    protected $perPage = 10;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'jabatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['kode', 'nama', 'deskripsi'];
}
