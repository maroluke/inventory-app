<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\InventoryItem;
use App\Models\User;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
    	return [
    	    'isbn' => $this->faker->word,
            'author' => $this->faker->name,
            'excerpt' => $this->faker->text,
            'release_date' => $this->faker->date,
            'language' => $this->faker->languageCode,
    	];
    }

    public function configure()
    {
        return $this->afterMaking(function (Book $book) {
            //
        })->afterCreating(function (Book $book) {
            $inventoryItem = new InventoryItem;
            $inventoryItem->name = $this->faker->word;
            $inventoryItem->user_id = User::all()->random()->id;
            $inventoryItem->location_id = Location::all()->random()->id;
            $inventoryItem->save();

            $inventoryItem->type()->associate($book)->save();
        });
    }
}
