<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'id_user',
        'id_shipping_method',
        'id_payment_method',
        'total_price',
        'status',
        'id_address',
    ];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class, 'id_payment_method');
    }

    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'id_shipping_method');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'id_address');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'id_order');
    }
}
