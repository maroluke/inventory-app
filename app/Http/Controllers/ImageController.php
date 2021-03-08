<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Http\Resources\ImageResource;

class ImageController extends Controller
{
    /**
     * @OA\Get(
     *      path="/api/image",
     *      operationId="listImage",
     *      tags={"Image"},
     *      summary="List images",
     *      description="Get a List of all images.",
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
        return ImageResource::collection(Image::all());
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
     *      path="/api/image",
     *      operationId="storeImage",
     *      tags={"Image"},
     *      summary="Create image",
     *      description="Create a new image.",
     *      @OA\Parameter(
     *         name="title",
     *         in="path",
     *         description="The title of the image.",
     *         required=true,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="alt",
     *         in="path",
     *         description="The alternative text of an image.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="image",
     *         in="path",
     *         description="The file of the image.",
     *         required=true,
     *         @OA\Schema(type="file")
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
            'title' => 'required|string',
            'alt' => 'string',
            'image' => 'required|image',
        ]);

        $file_name = uniqid();
        $file = $request->file('image');
        $file->storeAs('public', $file_name);
        URL::asset('storage/' . $file_name);
        
        $image = new Image;
        $image->title = $request->title;
        $image->alt = $request->alt;
        $image->ulr = 'storage/' . $file_name;
        $image->save();
    }

    /**
     * @OA\Get(
     *      path="/api/image/{id}",
     *      operationId="showImage",
     *      tags={"Image"},
     *      summary="Show image",
     *      description="Display a single image",
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
        return new ImageResource(Image::findOrFail($id));
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
     *      path="/api/image/{id}",
     *      operationId="updateImage",
     *      tags={"Image"},
     *      summary="Update image",
     *      description="Update an image.",
     *      @OA\Parameter(
     *         name="title",
     *         in="path",
     *         description="The title of the image.",
     *         required=false,
     *         @OA\Schema(type="string")
     *      ),
     *      @OA\Parameter(
     *         name="alt",
     *         in="path",
     *         description="The alternative text of an image.",
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
            'title' => 'string',
            'alt' => 'string',
        ]);

        $image = Image::findOrFail($id);
        if ($request->title) $image->title = $request->title;
        if ($request->alt) $image->alt = $request->alt;
        $image->save();
    }

    /**
     * @OA\Delete(
     *      path="/api/image/{id}",
     *      operationId="deleteImage",
     *      tags={"Image"},
     *      summary="Delete image",
     *      description="Delete a image.",
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
        $image = Image::findOrFail($id);

        if (File::exists($image->url)) {
            File::delete($image->url);
        }

        $image->delete();
    }
}
