<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obras extends Model
{
    protected $table = 'obras';
    protected $fillable = ['name', 'phone_number', 'address', 'rate_per_piece', 'latitude', 'longitude'];
}
