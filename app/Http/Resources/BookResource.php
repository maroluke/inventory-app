<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'name' => $this->inventoryItem->name,
            'user' => $this->inventoryItem->user,
            'location' => $this->inventoryItem->location,
            'isbn' => $this->isbn,
            'author' => $this->author,
            'excerpt' => $this->excerpt,
            'releaseDate' => $this->release_date,
            'language' => $this->language,
        ];
    }
}
