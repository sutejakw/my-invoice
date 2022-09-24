<?php

namespace App\Models\Invoice;

use App\Models\Customer\Customer;
use App\Models\InvoiceItem\InvoiceItem;

trait InvoiceRelationship
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
