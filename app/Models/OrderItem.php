<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'current_price',
    ];

    public function product() : HasOne
    {
        return $this->hasOne(Product::class,  'id_product');
    }

    public function order() : HasOne
    {
        return $this->hasOne(Order::class,  'id_order');
    }
}
