<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 
 *
 * @property int $user_id
 * @property string $jabatan
 * @property int $unit_id
 * @property string $departemen
 * @property string|null $no_hp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Unit $unit
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereDepartemen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUnitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserDetail withoutTrashed()
 * @mixin \Eloquent
 */
class UserDetail extends Model
{
    use SoftDeletes, HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "user_detail";

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'jabatan',
        'departemen',
        'no_hp',
        'unit_id'
    ];


    /**
     * Get the user that owns the UserDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the unit that owns the UserDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
