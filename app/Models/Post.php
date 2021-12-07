<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'title',
        'picture_file_1',
        'picture_file_2',
        'picture_file_3',
        'video_file_1',
        'video_file_2',
    ];
    protected $dates = [
        'deleted_at'
    ];

    public function month()
    {
        return $this->belongsTo(Month::class);
    }
}
