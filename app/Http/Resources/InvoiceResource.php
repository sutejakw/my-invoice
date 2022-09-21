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
            'customer' => new CustomerResource($this->customer),
            'due_date' => $this->due_date,
            'total' => $this->total
        ];
    }
}
