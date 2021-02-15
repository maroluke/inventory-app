<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Http\Resources\InventoryItemResource;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'type_id' => 'poly_exists:type_type',
            'user_id' => 'required|exists:App\Model\User,id',
            'location_id' => 'required|exists:App\Model\Location,id',
        ]);

        $inventoryItem = new InventoryItem;
        $inventoryItem->name = $request->name;
        $inventoryItem->type_id = $request->type_id;
        $inventoryItem->type_type = $request->type_type;
        $inventoryItem->user_id = $request->user_id;
        $inventoryItem->location_id = $requset->location_id;
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
            'user_id' => 'exists:App\Model\User,id',
            'location_id' => 'exists:App\Model\Location,id',
        ]);

        $inventoryItem = InventoryItem::findOrFail($id);
        if ($request->name) $inventoryItem->name = $request->name;
        if ($request->user_id) $inventoryItem->user_id = $request->user_id;
        if ($request->location_id) $inventoryItem->location_id = $request->location_id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $inventoryItem = InventoryItem::findOrFail($id);
        if ($inventoryItem->type) $inventoryItem->type->delete();
        $inventoryItem->delete();
    }
}
