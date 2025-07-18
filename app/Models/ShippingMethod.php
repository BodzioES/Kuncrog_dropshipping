<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = 'shipping_methods';

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'id_shipping_method');
    }
}
