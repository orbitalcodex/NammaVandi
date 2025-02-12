<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BikeServices extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bike()
    {
        return $this->belongsTo(Bikes::class);
    }

    
}
