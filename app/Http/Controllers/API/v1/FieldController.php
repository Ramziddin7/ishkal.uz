<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\FieldRelationResource;
use App\Http\Resources\FieldResource;
use App\Models\Field;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FieldController extends Controller
{

    public $dataError = [
        "data" => null,
        "message" => "Field not found",
    ];

    public $dataSuccess = [
        "data" => null,
        "message" => "Field deleted successfully !",
    ];


    public $cannotDelete = [
        "data" => null,
        "message" => "Content  conn't be deleted , becouse it connected to another table ",
    ];
    

     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/field",
     * summary="Return only fields ",
     * description="Get all data",
     * tags={"Field"},
     *       @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *           @OA\MediaType(
     *             mediaType="application/json",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *     )
     * )
     * 
     */
    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        return FieldResource::collection(Field::all());
    }

    /*
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/field",
     * summary="Post a new data",
     * description="Post new University  data",
     * tags={"Field"},
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Country   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"university_id","country_id","name","category","price","duration","description"},
     *       @OA\Property(property="university_id", type="number", format="int", example="1"),
     *       @OA\Property(property="country_id", type="number", format="int", example="2"),
     *       @OA\Property(property="name", type="text", format="text", example="Computer science"),
     *       @OA\Property(property="category", type="text", format="text", example="Master"),
     *       @OA\Property(property="price", type="text", format="string", example="$2000"),
     *       @OA\Property(property="duration", type="text", format="string", example="12 monthy"),
     *       @OA\Property(property="description", type="text", format="text", example="something"),
     *    ),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="The given data was invalid.")
     *        )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    /*
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'university_id'=>['required','exists:universities,id'],
            'country_id'=>['required','exists:countries,id'],
            'name'=>['required'],
            'category'=>['required'],
            'price'=>['required'],
            'duration'=>['required'],
            'description'=>['required'],
        ]);

        $field = new Field();
        $field->country_id = $request->country_id;
        $field->university_id = $request->university_id;
        $field->name = $request->name;
        $field->category = $request->category;
        $field->price = $request->price;
        $field->duration = $request->duration;
        $field->description = $request->description;
        $field->save();
        return response()->json(new FieldResource($field),200);
    }

    
     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/field/{field}",
     * summary="Get one ",
     * description="Return all date related to ID{field id}",
     * tags={"Field"},
     *  @OA\Parameter(name="field", in="path", description="ID", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    /*
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show($field)
    {
        $field = Field::find($field);
        if($field){
            return response()->json(new FieldResource($field),200);
        }
        return response()->json($this->dataError,404);
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        //
    }


    
         /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/field/{field}",
     * summary="Get one and Delete related to field id",
     * description="Return  date related to ID of the field",
     * tags={"Field"},
     * 
     * *@OA\Parameter(name="field", in="path", description="put field id and try to delete ", required=true,
     *       @OA\Schema(type="integer")
     *  ),
     *   @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    /*
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($field)
    {
        $field = Field::find($field);
        if($field){
            $field->delete();
            return response()->json($this->dataSuccess,200);
        }
        return response()->json($this->dataError,200);
    }

      
     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/fields/{field}/field",
     * summary="Get one with all the relation data ",
     * description="Return all date related to ID{field id}",
     * tags={"Field"},
     *  @OA\Parameter(name="field", in="path", description="ID of the field ", required=true,
     *        @OA\Schema(type="integer")
     *    ),
     *    @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *            @OA\MediaType(
     *             mediaType="application/json",
     *         ),
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
     */
    /*
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function getAllTheRelation($field)
    {
        $field = Field::find($field);
        if($field){
            return response()->json(new FieldRelationResource($field),200);
        }
        return response()->json($this->dataError,404);
    }
}
