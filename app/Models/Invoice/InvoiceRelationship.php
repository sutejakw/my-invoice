<?php

namespace App\Models\Invoice;

use App\Models\Customer\Customer;

trait InvoiceRelationship
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
