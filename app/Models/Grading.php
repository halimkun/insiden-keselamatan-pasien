<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Grading
 *
 * @property $id
 * @property $grading_risiko
 * @property $created_by
 * @property $created_at
 * @property $updated_at
 * @property $deleted_at
 * @property User $user
 * @property Insiden[] $insidens
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
class Grading extends Model
{
    use SoftDeletes;

    protected $perPage = 20;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'grading';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['grading_risiko', 'created_by'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    public function oleh()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insidens()
    {
        return $this->hasMany(\App\Models\Insiden::class, 'id', 'grading_id');
    }
}
