<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id', 'user_id', 'content', 'rating'
    ];

    public function course()
    {
        return $this->hasOne(Course::class);
    }


}
