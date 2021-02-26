<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
    	return [
    	    'branch' => $this->faker->word,
            'room' => $this->faker->word,
            'shelf' => $this->faker->word,
            'compartment' => $this->faker->word,
    	];
    }
}
