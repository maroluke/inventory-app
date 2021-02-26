<?php

namespace Database\Factories;

use App\Models\InventoryItem;
use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryItemFactory extends Factory
{
    protected $model = InventoryItem::class;

    public function definition(): array
    {
    	return [
    	    'name' => $this->faker->word,
            'user_id' => User::all()->random()->id,
            'location_id' => Location::all()->random()->id,
    	];
    }
}
