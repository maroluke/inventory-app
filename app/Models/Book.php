<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    
    /**
     * Get the inventory item the book belongs to.
     * 
     * @return InventoryItem
     */
    public function inventoryItem() {
        return $this->morphOne(InventoryItem::class, 'type');
    }

}
