<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryToObras extends Model
{
    protected $table = 'delivery_to_obras';

    protected $fillable = [
        'courier_id',
        'obras_id',
        'delivery_date',
        'due_date',
        'material_weight',
        'remaining',
        'status',
    ];

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function obras()
    {
        return $this->belongsTo(Obras::class);
    }
}
