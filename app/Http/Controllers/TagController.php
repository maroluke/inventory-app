<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Resources\TagResource;

class TagController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/tag",
     *      operationId="listTag",
     *      tags={"Tag"},
     *      summary="List tags",
     *      description="Get a List of all tags",
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
        return TagResource::collection(Tag::all());
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
     *      path="/api/tag",
     *      operationId="storeTag",
     *      tags={"Tag"},
     *      summary="Create tag",
     *      description="Create a new Tag",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The display name of the tag.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="inventory_item_id",
     *         in="path",
     *         description="The inventory item the tag is associated with.",
     *         required=true,
     *         @OA\Schema(type="integer")
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
            'inventory_item_id' => 'required|exists:App\Models\InventoryItem,id',
        ]);

        $tag = new Tag;
        $tag->name = $request->name;
        $tag->inventory_item_id = $request->inventory_item_id;
        $tag->save();
    }

    /**
     * @OA\Get(
     *      path="/api/tag/{id}",
     *      operationId="showTag",
     *      tags={"Tag"},
     *      summary="Show tag",
     *      description="Display a single tag",
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
        return new TagResource(Tag::findOrFail($id));
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
     *      path="/api/tag/{id}",
     *      operationId="updateTag",
     *      tags={"Tag"},
     *      summary="Update tag",
     *      description="Update variables of a tag.",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The display name of the tag.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="inventory_item_id",
     *         in="path",
     *         description="The inventory item the tag is associated with.",
     *         required=false,
     *         @OA\Schema(type="integer")
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
            'inventory_item_id' => 'exists:App\Model\InventoryItem,id',
        ]);

        $tag = Tag::findOrFail($id);
        if ($request->name) $tag->name = $request->name;
        if ($request->inventoryItemId) $tag->inventory_item_id = $request->inventory_item_id;
        $tag->save();
    }

    /**
     * @OA\Delete(
     *      path="/api/tag/{id}",
     *      operationId="deleteTag",
     *      tags={"Tag"},
     *      summary="Delete tag",
     *      description="Delete a tag.",
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
        Tag::destroy($id);
    }
}
