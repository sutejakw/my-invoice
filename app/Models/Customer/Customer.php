<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $appends = ['fullname'];

    protected function fullname(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $attributes['firstname'].' '.$attributes['lastname'],
        );
    }
}
