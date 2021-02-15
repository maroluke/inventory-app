<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\Book;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'user_id' => 'required|exists:App\Model\User,id',
            'location_id' => 'required|exists:App\Model\Location,id',
            'isbn' => 'string',
            'author' => 'required|string',
            'excerpt' => 'string',
            'release_date' => 'date',
            'language' => 'required|string',
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
        $inventoryItem->type = $book;
        $inventoryItem->user_id = $request->user_id;
        $inventoryItem->location_id = $request->location_id;
        $inventoryItem->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
        ]);

        $book = Book::findOrFail($id);
        if ($requset->name) $book->inventoryItem->name = $request->name;
        if ($request->isbn) $book->isbn = $request->isbn;
        if ($request->author) $book->author = $request->author;
        if ($request->excerpt) $book->excerpt = $request->excerpt;
        if ($request->release_date) $book->release_date = $request->release_date;
        if ($request->language) $book->language = $request->language;
        $book->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->inventoryItem->delete();
        $book->delete();
    }
}
