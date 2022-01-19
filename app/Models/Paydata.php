<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paydata extends Model
{
    protected $fillable = ['username', 'phone', 'email','order','status'];
}

