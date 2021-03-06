<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stream extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'type',
        'url',
        'status',
        'cover',
    ];

    protected $dates = [
        'deleted_at'
    ];
}
