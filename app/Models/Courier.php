<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Courier extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'couriers';

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'status',
        'device_token'
    ];

    protected $hidden = ['password', 'remember_token'];
}

