<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grading extends Model
{
    protected $table = "grading";

    protected $perPage = 20;

    protected $fillable = [
        "insiden_id",
        "grading_risiko",
        "created_by",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
