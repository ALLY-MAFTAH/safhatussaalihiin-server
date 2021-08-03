<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Month extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function year()
    {
        return $this->belongsTo(Year::class);
    }

    public function pictures()
    {
        return $this->hasMany(Picture::class);
    }
    public function videos()
    {
        return $this->hasMany(Video::class);
    }
}
