<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calls extends Model
{
    protected $table = 'calls';
    protected $fillable = ['user_id', 'notes', 'status', 'called_by', 'called'];
    use HasFactory;
}
