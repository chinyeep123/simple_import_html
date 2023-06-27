<?php

namespace App\Http\Resources\API\Product;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\API\Product\Resource;

class CollectionResource extends ResourceCollection
{
    public $collects = Resource::class;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
