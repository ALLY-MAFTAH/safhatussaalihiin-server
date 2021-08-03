<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'file',
        'date',
        'title'

    ];
    protected $dates = [
        'deleted_at'
    ];

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
