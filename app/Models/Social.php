<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $fillable = ['host_id','instagram','linkedin','website','facebook', 'telegram'];

    public function host()
    {
        return $this->hasOne(Host::class,'id','host_id');
    }
}
