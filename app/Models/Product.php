<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        //'image_url',
        'name',
        'description',
        'price',
        'stock_quantity',
        'id_products_categories'
    ];

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }
}
