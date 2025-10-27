<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cutter extends Model
{
    protected $table = 'cutters';
    protected $fillable = ['name', 'phone_number', 'address', 'rate_per_piece', 'latitude', 'longitude'];
}
