<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secondary extends Model
{
    use HasFactory;

    public function course()
    {
        return $this->hasOne(Course::class,'id','id_course');
    }

    public function category()
    {
        return $this->hasOne(Category::class,'id','id_category');
    }
}
