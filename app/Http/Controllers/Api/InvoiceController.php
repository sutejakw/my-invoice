<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Counter\Counter;
use App\Models\Invoice\Invoice;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;

class InvoiceController extends Controller
{
    /**
     * Get all invoices.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $resource = Invoice::with('customer')->get();
            $invoices = InvoiceResource::collection($resource);

            return ResponseFormatter::success($invoices);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }


    /**
     * Search invoice by id
     * 
     * @return JsonResponse
     */
    public function searchInvoice(Request $request): JsonResponse
    {
        $search = $request->get('s');

        try {
            $invoices = Invoice::with('customer')
                ->when($search != null, function ($query) use ($search) {
                    $query->where('id', 'LIKE', '%'.$search.'%');
                })
                ->get();

            return ResponseFormatter::success($invoices);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }

    /**
     * Create a new invoice
     * 
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $counter = Counter::where('key', 'invoice')->first();
        $random = Counter::where('key', 'invoice')->first();

        $invoice = Invoice::orderBy('id', 'DESC')->first();
        if ($invoice) {
            $invoice = $invoice->id+1;
            $counters = $counter->value + $invoice;
        } else {
            $counters = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' => 0,
            'terms_and_conditions' => 'Default Terms and Conditions',
            'items' => [
                [
                    'product_id' => null,
                    'product' => null,
                    'unit_price' => null,
                    'quantity' => null,
                ]
            ],
        ];

        return ResponseFormatter::success($formData);
    }
}
