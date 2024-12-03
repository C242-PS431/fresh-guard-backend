<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StoreResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $galeries = new StoreGaleryCollection($this->storeGaleries);
        unset($galeries->additional['total']);

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'address' => $this->address,
            'operation_time' => $this->operation_time,
            'phone' => $this->phone,
            'is_favorited' => $request->user()->isFavoritedStore($this->id),
            'gmap_url' => $this->gmap_url,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'galeries' => $this->when(isset($this->additional['status']), $galeries)
        ];
    }
}
