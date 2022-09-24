<?php

namespace App\Http\Resources;

use App\Http\Resources\CustomerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'number' => $this->number,
            'due_date' => $this->due_date,
            'sub_total' => $this->sub_total,
            'discount' => $this->discount,
            'total' => $this->total,
            'terms_and_conditions' => $this->terms_and_conditions,
            'reference' => $this->reference,
            'created_at' => $this->created_at,
            'customer' => new CustomerResource($this->customer),
            'items' => InvoiceItemResource::collection($this->items),
        ];
    }
}
