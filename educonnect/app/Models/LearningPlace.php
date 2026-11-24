<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningPlace extends Model
{
    protected $fillable = [
        'name',
        'category',
        'address',
        'description',
        'image',
    ];
}