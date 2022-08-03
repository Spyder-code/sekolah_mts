<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;
    protected $fillable = ['course_id', 'user_id', 'point'];

    public function course()
    {
        return $this->belongsTo('App\Models\Course');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
