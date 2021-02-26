<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\User;

class LocationTest extends TestCase
{
    /**
     * Test the creation of a location using valid data.
     *
     * @return void
     */
    public function testLocationCreationUsingValidData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'branch' => 'Twofold Asperger-Academy',
            'room' => '431',
            'shelf' => '3',
            'compartment' => '4',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a location with missing data.
     *
     * @return void
     */
    public function testLocationCreationWithMissingData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'room' => '431',
            'shelf' => '3',
            'compartment' => '4',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a location with empty data.
     *
     * @return void
     */
    public function testLocationCreationWithEmptyData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/location", [
            'branch' => '',
            'room' => '431',
            'shelf' => '3',
            'compartment' => '4',
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a location without login.
     *
     * @return void
     */
    public function testLocationCreationWithoutLogin()
    {
        $this->post("api/location", [
            'branch' => '',
            'room' => '431',
            'shelf' => '3',
            'compartment' => '4',
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Update the branch of a location.
     *
     * @return void
     */
    public function testLocationBranchUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/1", [
            'branch' => 'Twofold',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update multiple attributes of a location.
     *
     * @return void
     */
    public function testLocationUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/location/2", [
            'branch' => 'Twofold',
            'room' => '105',
            'shelf' => '9',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Update a location without login.
     *
     * @return void
     */
    public function testLocationUpdateWithoutLogin()
    {
        $this->patch("api/location/2", [
            'branch' => 'Twofold',
            'room' => '105',
            'shelf' => '9',
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test deletion of a location without login.
     *
     * @return void
     */
    public function testLocationDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/location/3");
        $this->seeStatusCode(200);
    }

    /**
     * Test deletion of a location without login.
     *
     * @return void
     */
    public function testLocationDeleteWithoutLogin()
    {
        $this->delete("api/location/61");
        $this->seeStatusCode(401);
    }
}
