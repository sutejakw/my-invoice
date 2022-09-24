<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use App\Models\Customer\Customer;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller
{
    /**
     * Get all customer.
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $resource = Customer::orderBy('id', 'DESC')->get();
            $customers = CustomerResource::collection($resource);

            return ResponseFormatter::success($customers);
        } catch (Exception $e) {
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }
}
