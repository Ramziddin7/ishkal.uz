<?php
namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UniversityRelationResource;
use App\Http\Resources\UniversityResource;
use App\Models\University;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UniversityController extends Controller
{

    public $dataError = [
        "data" => null,
        "message" => "University not found",
    ];

    public $dataSuccess = [
        "data" => null,
        "message" => "University deleted successfully !",
    ];

    public $cannotDelete = [
        "data" => null,
        "message" => "Content  conn't be deleted , becouse it connected to fields ",
    ];

    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/university",
     * summary="Return only name and image for the  first page to avoid large date",
     * description="Return only name and image for the  first page",
     * tags={"University"},
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
    public function index()
    {
        return UniversityResource::collection(University::all());
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
     * path="/v1/university",
     * summary="Post a new data",
     * description="Post new University  data",
     * tags={"University"},
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Country   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"name","image","country_id","categories","contractFile","min_price","min_ielts","city_name"},
     *       @OA\Property(property="name", type="text", format="text", example="AQSH"),
     *       @OA\Property(property="image", type="string", format="binary"),
     *       @OA\Property(property="country_id", type="number", format="number", example="3"),
     *       @OA\Property(property="categories", type="text", format="text", example="Master"),
     *       @OA\Property(property="contractFile", type="string", format="binary", example=""),
     *       @OA\Property(property="min_price", type="text", format="string", example="$2000"),
     *       @OA\Property(property="min_ielts", type="text", format="text", example="5.5"),
     *       @OA\Property(property="city_name", type="text", format="text", example="New York"),
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
            'country_id'=>['required','exists:countries,id'],
            'categories'=>['required'],
            'contractFile'=>['required','mimes:pdf,xlxs,xlx,docx,doc,csv,txt|max:4096'],
            'name'=>['required'],
            'min_price'=>['required'],
            'min_ielts'=>['required'],
            'city_name'=>['required'],
            'image'=>['required','mimes:jpeg,png,jpg'],
        ]);

        // return  $fileName = $request->contractFile->getClientOriginalName();;

        if($request->file('image')){
            $getImage = $request->file('image');
            $imageName = $getImage->getClientOriginalName();
            $imageFullName = time().''. $imageName;
            $imageFullName = str_replace([' '],[''],$imageFullName);
            $imagePath = $getImage->move(('images'),$imageFullName);
        }
            $fileGet = $request->file('contractFile');
            $fileName = $request->contractFile->getClientOriginalName();
            $fileFullName = time().''. $fileName;
            $fileName = str_replace([' '],[''],$fileFullName);
            $filePath = $fileGet->move(('uploads'),$fileName);
    

        $univer = new University();
        $univer->country_id = $request->country_id->value;
        $univer->categories = $request->categories->label;
        $univer->image = $imagePath;
        $univer->contractFile = $filePath;
        $univer->name = $request->name;
        $univer->min_price = $request->min_price;
        $univer->min_ielts = $request->min_ielts->value;
        $univer->city_name = $request->city_name;
        $univer->save();
        return response()->json(new UniversityResource($univer),200);
    }



     
       /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/university/{university}",
     * summary="Get one with field relation data !",
     * description="Return all date related to ID{university id}",
     * tags={"University"},
     *  @OA\Parameter(name="university", in="path", description="ID", required=true,
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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show($university)
    {
        $university = University::find($university);
        if($university){
            return response()->json(new UniversityResource($university),200);
        }
        return response()->json($this->dataError,404);
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function edit(University $university)
    {
        //
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, University $university)
    {
        //
    }

             /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/university/{university}",
     * summary="Get one and Delete related to university id",
     * description="Return  date related to ID of the university",
     * tags={"University"},
     * 
     * *@OA\Parameter(name="university", in="path", description="put university id and try to delete ", required=true,
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
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy($university)
    {
        try{
        $univer = University::find($university);
        if($univer){
            $univer->delete();
            return response()->json($this->dataSuccess,200);
        }
        return response()->json($this->dataError,404);
       }catch(Exception $e){
        return $this->cannotDelete;
       }
    }
    


     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/universities/{university}/field",
     * summary="Get one return with relation data from database like fields all the field come here ! ",
     * description="Return all date related to ID{university id}",
     * tags={"University"},
     *  @OA\Parameter(name="university", in="path", description="University id", required=true,
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

    
   
    public function field($university)
    {
        $university = University::find($university);
        if($university){
            return response()->json(new UniversityRelationResource($university),200);
        }
        return response()->json($this->dataError,404);
    }

}
