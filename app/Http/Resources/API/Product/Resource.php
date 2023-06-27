<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Resource extends JsonResource
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
            'id' => $this->getKey(),
            'product_id' => $this->product->getKey(),
            'type' => $this->product->type->name,
            'brand' => $this->product->typeBrand->name,
            'model' => $this->product->brandModel->name,
            'capacity' => $this->product->modelCapacity->name,
            'quantity' => $this->quantity,
        ];
    }
}
