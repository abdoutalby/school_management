<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $guarded = [];

    public function class()
    {
        return $this->belongsTo(ClassRoom::class);
    }
} 