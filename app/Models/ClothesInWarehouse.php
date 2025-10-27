<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesInWarehouse extends Model
{
    protected $table = 'clothes_in_warehouse';

    protected $fillable = [
        'obras_id',
        'date_in',
        'quantity',
        'clothing_type',
        'size',
        'notes',
    ];

    public function obras()
    {
        return $this->belongsTo(Obras::class);
    }
}
