<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    
    use HasFactory;

    /**
     * Get the inventory item the book belongs to.
     * 
     * @return InventoryItem
     */
    public function inventoryItem() {
        return $this->morphOne(InventoryItem::class, 'type');
    }

}
