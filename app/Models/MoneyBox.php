<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyBox extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'money_box_category_id',
        'amount',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function money_box_category()
    {
        return $this->belongsTo(MoneyBoxCategory::class, 'money_box_category_id');
    }
}
