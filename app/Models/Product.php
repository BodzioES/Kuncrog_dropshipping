<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class,'id_products_categories');
    }

    public function isSelectedCategory(int $id_products_categories): bool
    {
        return $this->hasCategory() && $this->category->id == $id_products_categories;
    }

    public function hasCategory(): bool
    {
        return !is_null($this->category);
    }
}
