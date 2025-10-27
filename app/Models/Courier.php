<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{

    protected $table = 'couriers';
    protected $fillable = ['user_id', 'phone_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
