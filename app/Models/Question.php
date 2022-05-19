<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $fillable = ['user_id','course_id','content'];

    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
