<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';

    protected $fillable = [
        'id_order',
        'id_product',
        'quantity',
        'current_price',
    ];

    public function product(): BelongsTo
    {
        # to id_product oraz id jest dodane poniewaz to sa nietypowe nazwy kolumna w tabeli ktore laravel sam by nie widzial
        # wiec trzeba je napisac aby doprecyzowac
        return $this->belongsTo(Product::class, 'id_product', 'id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
