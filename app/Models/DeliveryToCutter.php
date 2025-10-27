<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryToCutter extends Model
{
     protected $table = 'delivery_to_cutters';

    protected $fillable = [
        'courier_id',
        'cutter_id',
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

    public function cutter()
    {
        return $this->belongsTo(Cutter::class);
    }
}
