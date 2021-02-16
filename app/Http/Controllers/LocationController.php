<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Http\Resources\LocationResource;

class LocationController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/location",
     *      operationId="listLocation",
     *      tags={"Location"},
     *      summary="List locations",
     *      description="Get a List of all locations.",
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
     * @OA\Post(
     *      path="/api/location",
     *      operationId="storeLocation",
     *      tags={"Location"},
     *      summary="Create location",
     *      description="Create a new location.",
     *      @OA\Parameter(
     *         name="branch",
     *         in="path",
     *         description="The branch of the company where the location is.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="room",
     *         in="path",
     *         description="The room the location is.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="shelf",
     *         in="path",
     *         description="The shelf the location is in.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="compartment",
     *         in="path",
     *         description="The compartment in the shelf of the location.",
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
     * @OA\Get(
     *      path="/api/location/{id}",
     *      operationId="showLocation",
     *      tags={"Location"},
     *      summary="Show location",
     *      description="Display a location",
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
     * @OA\Patch(
     *      path="/api/location/{id}",
     *      operationId="updateLocation",
     *      tags={"Location"},
     *      summary="Update location",
     *      description="Update a new location.",
     *      @OA\Parameter(
     *         name="branch",
     *         in="path",
     *         description="The branch of the company where the location is.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="room",
     *         in="path",
     *         description="The room the location is.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="shelf",
     *         in="path",
     *         description="The shelf the location is in.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="compartment",
     *         in="path",
     *         description="The compartment in the shelf of the location.",
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
     * @OA\Delete(
     *      path="/api/location/{id}",
     *      operationId="deleteLocation",
     *      tags={"Location"},
     *      summary="Delete location",
     *      description="Delete a location.",
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
        Location::destroy($id);
    }
}
