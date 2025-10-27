<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Overdeck extends Model
{
    protected $table = 'overdecks';
    protected $fillable = ['name', 'phone_number', 'rate_per_piece'];
}
