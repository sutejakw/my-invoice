<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Invoice\Invoice;
use App\Http\Controllers\Controller;

class InvoiceController extends Controller
{
    /**
     * get all invoices
     */
    public function index()
    {
        $invoices = Invoice::with('customer')->get();

        return response()->json( [
            'invoices' => $invoices
        ], 200);
    }
}
