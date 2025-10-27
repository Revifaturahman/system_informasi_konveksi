<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryToTailor extends Model
{
    use HasFactory;

    protected $table = 'delivery_to_tailors';

    protected $fillable = [
        'courier_id',
        'tailor_id',
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

    public function tailor()
    {
        return $this->belongsTo(Tailor::class);
    }
}
