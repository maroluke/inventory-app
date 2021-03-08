<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\Book;
use App\Http\Resources\BookResource;
use App\Http\Controllers\InventoryItemController;

class BookController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/book",
     *      operationId="listBook",
     *      tags={"Book"},
     *      summary="List books",
     *      description="Get a List of all books.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function index()
    {
        return BookResource::collection(Book::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * @OA\Post(
     *      path="/api/book",
     *      operationId="storeBook",
     *      tags={"Book"},
     *      summary="Create book",
     *      description="Create a new book.",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The title of the book.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="The id of the user created the book.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="location_id",
     *         in="path",
     *         description="The location the book is stored in.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="isbn",
     *         in="path",
     *         description="The isbn number of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="The author of the book.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="excerpt",
     *         in="path",
     *         description="A short text that describes the content of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="release_date",
     *         in="path",
     *         description="The date the book was released on.",
     *         required=false,
     *         @OA\Schema(type="date")
     *      ),
     *      @OA\Parameter(
     *         name="language",
     *         in="path",
     *         description="The language the book is written in.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|exists:App\Models\User,id',
            'location_id' => 'required|exists:App\Models\Location,id',
            'isbn' => 'string',
            'author' => 'required|string',
            'excerpt' => 'string',
            'release_date' => 'date',
            'language' => 'required|string',
            'image_ids' => 'array',
            'images.*' => 'image',
        ]);

        $book = new Book;
        $book->isbn = $request->isbn;
        $book->author = $request->author;
        $book->excerpt = $request->excerpt;
        $book->release_date = $request->release_date;
        $book->language = $request->language;
        $book->save();

        $inventoryItem = new InventoryItem;
        $inventoryItem->name = $request->name;
        $inventoryItem->user_id = $request->user_id;
        $inventoryItem->location_id = $request->location_id;
        $inventoryItem->save();

        $inventoryItem->type()->associate($book)->save();

        $inventoryItemController = new InventoryItemController;
        $inventoryItemController->saveImages($inventoryItem, $request->image_ids, $request->images);
    }

    /**
     * @OA\Get(
     *      path="/api/book/{id}",
     *      operationId="showBook",
     *      tags={"Book"},
     *      summary="Show book",
     *      description="Display a book",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function show($id)
    {
        return new BookResource(Book::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Patch(
     *      path="/api/book/{id}",
     *      operationId="updateBook",
     *      tags={"Book"},
     *      summary="Update book",
     *      description="Update a book.",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The title of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="The id of the user created the book.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="location_id",
     *         in="path",
     *         description="The location the book is stored in.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="isbn",
     *         in="path",
     *         description="The isbn number of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="author",
     *         in="path",
     *         description="The author of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="excerpt",
     *         in="path",
     *         description="A short text that describes the content of the book.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="release_date",
     *         in="path",
     *         description="The date the book was released on.",
     *         required=false,
     *         @OA\Schema(type="date")
     *      ),
     *      @OA\Parameter(
     *         name="language",
     *         in="path",
     *         description="The language the book is written in.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'string',
            'isbn' => 'string',
            'author' => 'string',
            'excerpt' => 'string',
            'release_date' => 'date',
            'language' => 'string',
            'image_ids' => 'array',
            'images.*' => 'image',
        ]);

        $book = Book::findOrFail($id);
        if ($request->name) {
             $book->inventoryItem->name = $request->name;
             $book->inventoryItem->save();
        }
        if ($request->isbn) $book->isbn = $request->isbn;
        if ($request->author) $book->author = $request->author;
        if ($request->excerpt) $book->excerpt = $request->excerpt;
        if ($request->release_date) $book->release_date = $request->release_date;
        if ($request->language) $book->language = $request->language;
        $book->save();

        // remove all images if the image id array changes
        if ($request->image_ids != null) {
            foreach ($inventoryItem->images as $image) {
                $book->inventoryItem->images()->detatch($image);
                $book->inventoryItem->save();
            }
        }

        $inventoryItemController = new InventoryItemController;
        $inventoryItemController->saveImages($book->inventoryItem, $request->image_ids, $request->images);
    }

    /**
     * @OA\Delete(
     *      path="/api/book/{id}",
     *      operationId="deleteBook",
     *      tags={"Book"},
     *      summary="Delete book",
     *      description="Delete a book.",
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthorized"
     *       ),
     *     )
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $inventoryItemId = $book->inventoryItem->id;

        $inventoryItemController = new InventoryItemController;

        return $inventoryItemController->destroy($inventoryItemId);
    }
}
