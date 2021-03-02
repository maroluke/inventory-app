<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\User;

class TagTest extends TestCase
{
    /**
     * Test the creation of a tag using valid data.
     *
     * @return void
     */
    public function testTagCreationUsingValidData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/tag", [
            "name" => "Java",
            "inventory_item_id" => "105",
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a tag referencing a non existent inventory item.
     *
     * @return void
     */
    public function testTagCreationOnInvalidItem()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/tag", [
            "name" => "Java",
            "inventory_item_id" => "900",
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a tag without inventory item.
     *
     * @return void
     */
    public function testTagCreationWithoutInventoryItem()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/tag", [
            "name" => "Java",
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a tag without a name.
     *
     * @return void
     */
    public function testTagCreationWithoutName()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/tag", [
            "inventory_item_id" => "10",
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a tag without empty name.
     *
     * @return void
     */
    public function testTagCreationWithEmptyName()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/tag", [
            "name" => "",
            "inventory_item_id" => "10",
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a tag without login.
     *
     * @return void
     */
    public function testTagCreationWithoutLogin()
    {
        $this->post("api/tag", [
            "name" => "",
            "inventory_item_id" => "10",
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Update the name of a tag.
     *
     * @return void
     */
    public function testTagNameUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/tag/1", [
            "name" => "New name",
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the inventory item of a tag.
     *
     * @return void
     */
    public function testTagInventoryItemUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/tag/1", [
            "inventory_item_id" => "3",
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update the name of a tag without login.
     *
     * @return void
     */
    public function testTagNameUpdateWithoutLogin()
    {
        $this->patch("api/tag/1", [
            "name" => "No login",
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting a tag.
     *
     * @return void
     */
    public function testTagDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/tag/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting a tag without login.
     *
     * @return void
     */
    public function testTagDeleteWithoutLogin()
    {
        $this->delete("api/tag/3");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing tag.
     *
     * @return void
     */
    public function testTagDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/tag/900");
        $this->seeStatusCode(404);
    }
}
