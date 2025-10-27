<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tailor extends Model
{
    protected $table = 'tailors';
    protected $fillable = ['name', 'phone_number', 'address', 'rate_per_piece', 'latitude', 'longitude'];
}
