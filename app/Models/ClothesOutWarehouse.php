<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothesOutWarehouse extends Model
{
    protected $table = 'clothes_out_warehouse';
    protected $fillable = ['date_out', 'product_variant_id', 'quantity_out', 'notes'];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
