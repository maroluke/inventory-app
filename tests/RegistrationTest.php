<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RegistrationTest extends TestCase
{
    /**
     * Test the user registration with correct example date.
     *
     * @return void
     */
    public function testExample()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(201);
    }

    /**
     * Test the registration with the same user.
     *
     * @return void
     */
    public function testExistingUser()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker@twofold.swiss",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with wrong data.
     *
     * @return void
     */
    public function testWrongData()
    {
        $this->post("api/auth/register", [
            "name" => "Jeremy Becker",
            "email" => "jeremy.becker",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the user registration with missing data.
     *
     * @return void
     */
    public function testMissingData()
    {
        $this->post("api/auth/register", [
            "email" => "jeremy.becker",
            "password" => "1234",
            "password_confirmation" => "1234"
        ]);
        $this->seeStatusCode(422);
    }
}
