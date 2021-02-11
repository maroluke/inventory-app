<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    
    /**
     * Get the inventory item wich is tagged with this tag.
     * 
     * @return InventoryItem
     */
    public function inventoryItem() {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

}
