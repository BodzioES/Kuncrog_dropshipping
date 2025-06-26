<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = [
      'street_and_house_number',
      'apartment_number',
      'city',
      'postal_code',
      'first_name',
      'last_name',
      'phone_number',
      'email',
    ];
    public function orders() : HasMany
    {
        return $this->hasMany(Order::class, 'id_address');
    }
}
