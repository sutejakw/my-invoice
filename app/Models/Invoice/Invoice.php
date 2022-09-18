<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    use InvoiceRelationship;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'number',
        'customer_id',
        'date',
        'due_date',
        'reference',
        'terms_and_conditions',
        'sub_total',
        'discount',
        'total',
    ];

}
