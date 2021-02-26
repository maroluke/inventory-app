<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    
    use HasFactory;

    /**
     * Get the inventory item stored at the location.
     * 
     * @return InventoryItem
     */
    public function inventoryItems() {
        return $this->hasMany(inventoryItem::class, 'location_id');
    }

}
