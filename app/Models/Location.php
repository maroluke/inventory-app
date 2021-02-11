<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    
    /**
     * Get the inventory item stored at the location.
     * 
     * @return InventoryItem
     */
    public function inventoryItems() {
        return $this->hasMany(inventoryItem::class, 'location_id');
    }

}
