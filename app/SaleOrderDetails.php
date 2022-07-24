<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrderDetails extends Model
{
    protected $fillable = [
        'order_id','product_id','qty','price'
    ];

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }
}
