<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';

    protected $fillable = [
        'id_product',
        'image_url',
        'is_main',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'id_product');
    }
}
