<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use Uuid;

    protected $fillable = [
        'name','category', 'description', 'classroom_id', 'quiz_provider_id', 'start_date', 'end_date', 'password'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    public function result()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function result_one()
    {
        return $this->hasOne(QuizResult::class,'quiz_id');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

}
