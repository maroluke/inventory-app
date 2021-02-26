<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    
    use HasFactory;

    /**
     * Get the user that created this item.
     * 
     * @return User
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the location the item is stored in.
     * 
     * @return Location
     */
    public function location() {
        return $this->belongsTo(Location::class, 'inventory_item_id');
    }

    /**
     * Get all tags associated with the item.
     * 
     * @return array
     */
    public function tags() {
        return $this->hasMany(Tag::class, 'inventory_item_id');
    }

    public function type() {
        return $this->morphTo();
    }

}
