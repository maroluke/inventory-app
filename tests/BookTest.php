<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

use App\Models\User;

class BookTest extends TestCase
{
    /**
     * Test the creation of a book using valid data.
     *
     * @return void
     */
    public function testBookCreationUsingValidData()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'user_id' => $user->id,
            'location_id' => '1',
            'isbn' => 'isbn number',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a book with missing name.
     *
     * @return void
     */
    public function testBookCreationWithMissingName()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'user_id' => $user->id,
            'location_id' => '1',
            'isbn' => 'isbn number',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book with missing isbn.
     *
     * @return void
     */
    public function testBookCreationWithMissingISBN()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'user_id' => $user->id,
            'location_id' => '1',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test the creation of a book with empty language.
     *
     * @return void
     */
    public function testBookCreationWithEmptyLanguage()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->post("api/book", [
            'name' => 'Buch',
            'user_id' => $user->id,
            'location_id' => '1',
            'isbn' => 'isbn number',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => '',  
        ]);
        $this->seeStatusCode(422);
    }

    /**
     * Test the creation of a book without login.
     *
     * @return void
     */
    public function testBookCreationWithoutLogin()
    {
        $this->post("api/book", [
            'name' => 'Buch',
            'user_id' => '1',
            'location_id' => '1',
            'isbn' => 'isbn number',
            'author' => 'Author Name',
            'excerpt' => 'About the book.',
            'releaseDate' => '01-01-2000 00:00:00',
            'language' => 'de',  
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test updating the author of a book.
     *
     * @return void
     */
    public function testBookAuthorUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/1", [
            'author' => 'Different Author',
        ]);
        $this->seeStatusCode(200);
    }

    /**
     * Test updating the name of a book.
     *
     * @return void
     */
    public function testBookNameUpdate()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->patch("api/book/1", [
            'name' => 'Different Name',
        ]);
        $this->seeStatusCode(200);
    }


    /**
     * Test updating the name of a book without Login.
     *
     * @return void
     */
    public function testBookNameUpdateWithoutLogin()
    {
        $this->patch("api/book/1", [
            'name' => 'Different Name',
        ]);
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting a book.
     *
     * @return void
     */
    public function testBookDelete()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/book/2");
        $this->seeStatusCode(200);
    }

    /**
     * Test deleting a book without Login.
     *
     * @return void
     */
    public function testBookDeleteWithoutLogin()
    {
        $this->delete("api/book/2");
        $this->seeStatusCode(401);
    }

    /**
     * Test deleting not existing book.
     *
     * @return void
     */
    public function testBookDeleteNotExisting()
    {
        $user = User::all()->random();

        $this->actingAs($user, 'api')
             ->delete("api/book/900");
        $this->seeStatusCode(404);
    }
}
