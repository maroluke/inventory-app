<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Resources\InventoryItemResource;

class InventoryItemController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/inventoryitem",
     *      operationId="listInventoryItem",
     *      tags={"Inventory Item"},
     *      summary="List inventory items",
     *      description="Get a List of all inventory items.",
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
        return InventoryItemResource::collection(InventoryItem::all());
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
     *      path="/api/inventoryitem",
     *      operationId="storeInventoryItem",
     *      tags={"Inventory Item"},
     *      summary="Create inventory item",
     *      description="Create a new inventory item.",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The name of the inventory item.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="type_id",
     *         in="path",
     *         description="The id of the morph item.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="type_type",
     *         in="path",
     *         description="The type of the morph item.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="The user id of the creator of the item.",
     *         required=true,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="location_id",
     *         in="path",
     *         description="The id of the location the item is stored in.",
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
            'type_id' => 'poly_exists:type_type',
            'user_id' => 'required|exists:App\Models\User,id',
            'location_id' => 'required|exists:App\Models\Location,id',
        ]);

        $inventoryItem = new InventoryItem;
        $inventoryItem->name = $request->name;
        $inventoryItem->type_id = $request->type_id;
        $inventoryItem->type_type = $request->type_type;
        $inventoryItem->user_id = $request->user_id;
        $inventoryItem->location_id = $request->location_id;
        $inventoryItem->save();
    }

    /**
     * @OA\Get(
     *      path="/api/inventoryitem/{id}",
     *      operationId="showInventoryItem",
     *      tags={"Inventory Item"},
     *      summary="Show inventory item",
     *      description="Display an inventory item",
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
        return new InventoryItemResource(InventoryItem::findOrFail($id));
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
     *      path="/api/inventoryitem/{id}",
     *      operationId="updateInventoryItem",
     *      tags={"Inventory Item"},
     *      summary="Update inventory item",
     *      description="Update variables in an inventory item.",
     *      @OA\Parameter(
     *         name="name",
     *         in="path",
     *         description="The name of the inventory item.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="type_id",
     *         in="path",
     *         description="The id of the morph item.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="type_type",
     *         in="path",
     *         description="The type of the morph item.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="The user id of the creator of the item.",
     *         required=false,
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *         name="location_id",
     *         in="path",
     *         description="The id of the location the item is stored in.",
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
            'user_id' => 'exists:App\Model\User,id',
            'location_id' => 'exists:App\Model\Location,id',
        ]);

        $inventoryItem = InventoryItem::findOrFail($id);
        if ($request->name) $inventoryItem->name = $request->name;
        if ($request->user_id) $inventoryItem->user_id = $request->user_id;
        if ($request->location_id) $inventoryItem->location_id = $request->location_id;
    }

    /**
     * @OA\Delete(
     *      path="/api/inventoryitem/{id}",
     *      operationId="deleteInventoryItem",
     *      tags={"Inventory Item"},
     *      summary="Delete inventory item",
     *      description="Delete an inventory item.",
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
        $inventoryItem = InventoryItem::findOrFail($id);
        if ($inventoryItem->type) $inventoryItem->type->delete();
        $inventoryItem->delete();
    }
}
