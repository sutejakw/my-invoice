<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Counter\Counter;
use App\Models\Invoice\Invoice;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Requests\Invoice\StoreInvoiceRequest;
use App\Models\InvoiceItem\InvoiceItem;

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
            $resource = Invoice::with('customer')->orderBy('id', 'DESC')->get();
            $invoices = InvoiceResource::collection($resource);

            return ResponseFormatter::success($invoices);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }


    /**
     * Search invoice by id
     * 
     * @param \Illuminate\Http\Request  $request
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

    /**
     * Create a new invoice
     * 
     * @param \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        DB::beginTransaction();
        try {
            $invoice = Invoice::create([
                'customer_id' => $request->customer_id,
                'date' => $request->date,
                'due_date' => $request->due_date,
                'number' => $request->number,
                'reference' => $request->ference,
                'discount' => $request->discount,
                'sub_total' => $request->sub_total,
                'total' => $request->total,
                'terms_and_conditions' => $request->terms_and_conditions,
            ]);

            foreach (json_decode($request->invoice_item) as $invoice_item) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $invoice_item->id,
                    'unit_price' => $invoice_item->unit_price,
                    'quantity' => $invoice_item->quantity,
                ]);
            }
            DB::commit();

            return ResponseFormatter::success($invoice);
        } catch (Exception $e) {

            return ResponseFormatter::error(null, $e->getMessage());
            DB::rollBack();
        }
    }

    public function show($id): JsonResponse 
    {
        try {
            $resource = Invoice::with(['customer', 'items'])->findOrFail($id);
            $invoice = new InvoiceResource($resource);

            return ResponseFormatter::success($invoice);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }
}
