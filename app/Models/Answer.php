<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    protected $fillable = ['user_id','question_id','content'];

    public function question()
    {
        return $this->hasOne(Question::class);
    }
}
