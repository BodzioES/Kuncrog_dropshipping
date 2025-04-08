<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    protected $table = 'cart';
    protected $fillable = [
        'id_user',
        'id_product',
        'name',
        'price',
        'quantity',
        'image_url',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'id_product');
        //powyzej jest id_product poniewaz w mojej bazie tak jest opisana kolumna
        //a laravel domyslnie szuka product_id wiec trzeba to dopisac aby laravel
        //szukal id_product
    }
}
