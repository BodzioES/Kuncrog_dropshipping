<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $table = 'products';
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

    # sprawdzic do czego to jest ponizej
    public function isSelectedCategory(int $id_products_categories): bool
    {
        return $this->hasCategory() && $this->category->id == $id_products_categories;
    }

    public function hasCategory(): bool
    {
        return !is_null($this->category);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class,'id_products')->orderBy('created_at','DESC');
    }

    public function mainImage(): HasOne
    {
        return $this->hasOne(ProductImage::class,'id_products')->where('main',true);
    }
}
