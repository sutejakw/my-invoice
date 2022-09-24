<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\InvoiceItem\InvoiceItem;

class InvoiceItemController extends Controller
{
    public function destroy($id, $invoice_id)
    {
        try {
            $item = InvoiceItem::where('invoice_id', $invoice_id)
                ->where('id', $id)
                ->first();

            $item->delete();

            return ResponseFormatter::success(null, 'Invoice item deleted successfully');
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }
}
