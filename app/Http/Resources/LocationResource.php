<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\InventoryItemResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'branch' => $this->branch,
            'room' => $this->room,
            'shelf' => $this->shelf,
            'compartment' => $this->compartment,
            'inventoryItems' => InventoryItemResource::collection($this->inventoryItems),
        ];
    }
}
