<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doc;
use Validator;

class DocController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    /**
     * List Doc
     * @OA\Get (
     *     path="/api/doc",
     *     tags={"Doc"},
     *     security={ 
     *          {"bearerAuth": {} }
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="image", type="string", example="path")
     *         )
     *     )
     * )
     */
    public function index() {
        return response()->json([
            'status'=>'success', 
            'data'=>Doc::paginate(10)
        ]);
    }

    /**
     * Get Detail Doc
     * @OA\Get (
     *     path="/api/doc/{id}",
     *     tags={"Doc"},
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     security={ 
     *          {"bearerAuth": {} }
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="image", type="string", example="path")
     *         )
     *     )
     * )
     */
    public function show($id) {
        // if (!$user) {
        //     throw new ModelNotFoundException('User not found by ID ' . $user_id);
        // }
        return response()->json([
            'status'=>'success', 
            'data'=>Doc::findOrFail($id)
        ]);
    }

    /**
     * Post Doc
     * @OA\Post (
     *     path="/api/doc",
     *     tags={"Doc"},
     *     security={ 
     *          {"bearerAuth": {} }
     *     },
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass doc",
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="title"),
     *                 @OA\Property(property="content", type="string", example="content"),
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="image",
     *                     type="file",
     *                ),
     *                required={"image"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="image", type="string", example="path")
     *         )
     *     )
     * )
     */
    public function create(Request $request){
        $validation = Validator::make($request->all(),[
            'title'=>'required|string',
            'content'=>'required|string',
            'image' => 'required|mimes:jpg,png,jpeg|max:2048',
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
        $file = $request->file('image');
        $path = $file->store('public/files');
       
        //php artisan storage:link

        $record = Doc::create([
            'title' => $request->get('title'),
            'content' => $request->get('content'),
            'image' => $path
        ]);

        return response()->json([
            'status'=>'success', 
            'data'=>$record
            ]
        );
    }

    /**
     * Update Doc
     * @OA\POST (
     *     path="/api/doc/{id}",
     *     tags={"Doc"},
     *     security={ 
     *          {"bearerAuth": {} }
     *     },
     *      @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          description="Pass doc",
     *          @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="title", type="string", example="title"),
     *                 @OA\Property(property="content", type="string", example="content"),
     *                 @OA\Property(property="_method", type="string", example="PUT"),
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="image",
     *                     type="file",
     *                ),
     *                required={"image"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="title", type="string", example="title"),
     *              @OA\Property(property="content", type="string", example="content"),
     *              @OA\Property(property="image", type="string", example="path")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $id) {
       
        $validation = Validator::make($request->all(),[
            'title'=>'required|string',
            'content'=>'required|string',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048',
        ]);
        if($validation->fails()) {
            return response()->json($validation->errors(), 422);
        }
       
        $record = Doc::find($id);
        $record->title = $request->get('title');
        $record->content = $request->get('content');
        
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('public/files');
            $record->image = $path;
            
            \Storage::delete($record->image);
        }
        $record->save();

        return response()->json([
            'status'=>'success', 
            'data'=>$record]
        );
    }

    /**
     * Delete Doc
     * @OA\Delete (
     *     path="/api/doc/{id}",
     *     tags={"Doc"},
     *     security={ 
     *          {"bearerAuth": {} }
     *     },
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete data success")
     *         )
     *     )
     * )
     */
    public function delete($id) {
        $record = Doc::find($id);
        if(!empty($record)) {

            \Storage::delete($record->image);
            $record->delete();
            return response()->json([
                'status'=>'success', 
                'data'=>$record->image
                ]
            );
        } else {
            return response()->json([
                'status'=>'success', 
                'data'=>"Data tidak ditemukan"
                ]
            );
        }
        
        
    }
}
