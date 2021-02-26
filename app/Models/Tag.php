<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tag extends Model
{
 
    use HasFactory;

    /**
     * Get the inventory item wich is tagged with this tag.
     * 
     * @return InventoryItem
     */
    public function inventoryItem() {
        return $this->belongsTo(InventoryItem::class, 'inventory_item_id');
    }

}
