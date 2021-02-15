<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return LocationResource::collection(Location::all());
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
            'branch' => 'required|string',
            'room' => 'required|string',
            'shelf' => 'required|string',
            'compartment' => 'required|string',
        ]);

        $location = new Location;
        $location->branch = $request->branch;
        $location->room = $request->room;
        $location->shelf = $request->shelf;
        $location->compartment = $request->compartment;
        $location->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new LocationResource(Location::findOrFail($id));
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
            'branch' => 'required|string',
            'room' => 'required|string',
            'shelf' => 'required|string',
            'compartment' => 'required|string',
        ]);

        $location = Location::findOrFail($id);
        if ($request->branch) $location->branch = $request->branch;
        if ($request->room) $location->room = $request->room;
        if ($request->shelf) $location->shelf = $request->shelf;
        if ($request->compartment) $location->compartment = $request->compartment;
        $location->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Location::destroy($id);
    }
}
