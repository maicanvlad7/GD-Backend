<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progress';


    protected $fillable = ['user_id', 'percent', 'completed', 'lesson_id', 'course_id'];

    use HasFactory;
}
