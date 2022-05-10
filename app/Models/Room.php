<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_students',
            'room_id', 'user_id');
    }

    public function classroom()
    {
        return $this->hasMany(Classroom::class, 'room_id');
    }
}
