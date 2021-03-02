<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\User;

class InventoryItemTest extends TestCase
{
    /**
     * Test the creation of an inventory item using valid data.
     *
     * @return void
     */
    public function testInventoryItemCreationUsingValidData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => 'Buch',
            'user_id' => $user->id,
            'location_id' => '1',  
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of an inventory item with missing user id.
     *
     * @return void
     */
    public function testInventoryItemCreationWithMissingUserId()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => 'Buch',
            'location_id' => '1',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of an inventory item with empty name.
     *
     * @return void
     */
    public function testInventoryItemCreationWithEmptyName()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/inventoryitem", [
            'name' => '',
            'user_id' => $user->id,
            'location_id' => '1',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of an inventory item without login.
     *
     * @return void
     */
    public function testInventoryItemCreationWithoutLogin()
    {
        $this->post("api/inventoryitem", [
            'name' => 'Buch',
            'user_id' => '1',
            'location_id' => '1',  
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test updating the name of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemNameUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/1", [
            'name' => 'Anderes Buch',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the user of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemUserUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/1", [
            'user_id' => 2,
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the location of an inventory item.
     *
     * @return void
     */
    public function testInventoryItemLocationUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/inventoryitem/1", [
            'location_id' => 31,
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the name of an inventory item without login.
     *
     * @return void
     */
    public function testInventoryItemNameUpdateWithoutLogin()
    {
        $this->patch("api/inventoryitem/1", [
            'name' => 'Anderes Buch',
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting an inventory item.
     *
     * @return void
     */
    public function testInventoryItemDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/inventoryitem/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting an inventory item without login.
     *
     * @return void
     */
    public function testInventoryItemDeleteWithoutLogin()
    {
        $this->delete("api/inventoryitem/3");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing inventory item.
     *
     * @return void
     */
    public function testInventoryItemDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/inventoryitem/900");
        $this->seeStatusCode(404);
    }
}
