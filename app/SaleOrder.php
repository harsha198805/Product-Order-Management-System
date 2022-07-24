<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    protected $fillable = [
        'customer_id','order_date'
    ];

    public function customer()
    {
        return $this->belongsTo(customer::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(SaleOrderDetails::class, 'order_id');
    }
}
