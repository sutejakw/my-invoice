<?php

namespace App\Models\InvoiceItem;

use App\Models\Invoice\Invoice;
use App\Models\Product\Product;

trait InvoiceItemRelationship
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
