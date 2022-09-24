<?php

namespace App\Models\InvoiceItem;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;
    use InvoiceItemRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'invoice_id',
        'product_id',
        'unit_price',
        'quantity',
    ];
}
