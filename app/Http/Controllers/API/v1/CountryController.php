<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryNameIdResource;
use App\Http\Resources\CountryRelationResource;
use Exception;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{

    public $dataError = [
        "data" => null,
        "message" => "Country not found",
    ];

    public $dataSuccess = [
        "data" => null,
        "message" => "Country deleted successfully !",
    ];

    public $cannotDelete = [
        "data" => null,
        "message" => "Content  conn't be deleted , becouse it connected to another table , after you deleted this data , all data will be deleted which is related this country !",
    ];


    /*
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/country",
     * summary="Return only name and image for the  first page to avoid large date",
     * description="Return only name and image for the  first page",
     * tags={"Country"},
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
        return CountryResource::collection(Country::all());
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
     * * * * * *  * * * *  * * * * * *
     * @OA\Post(
     * path="/v1/country",
     * summary="Post a new data",
     * description="Post new coutry  data",
     * tags={"Country"},
     * 
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass Country   credentials",
     *    @OA\MediaType(
     *       mediaType="multipart/form-data",
     *       @OA\Schema(
     *       type="object",
     *       required={"name","image"},
     *       @OA\Property(property="name", type="text", format="text", example="AQSH"),
     *       @OA\Property(property="image", type="string", format="binary", example="image"),
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
            'name'=>['required'],
            'image'=>['required','mimes:jpeg,png,jpg'],
        ]);

        if($request->file('image')){
            $getImage = $request->file('image');
            $imageName = $getImage->getClientOriginalName();
            $imageFullName = time().''. $imageName;
            $imageFullName = str_replace([' '],[''],$imageFullName);
            $path = $getImage->move(('images'),$imageFullName);
        }

        $country = new Country();
        $country->name = $request->name;
        $country->image = $path ?? 'images\no-image-university.jpeg ';
        $country->save();
        return response()->json(new CountryResource($country),200);
    }

    



     /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/country/{country}",
     * summary="Get one ",
     * description="Return all date related to ID{country id}",
     * tags={"Country"},
     *  @OA\Parameter(name="country", in="path", description="ID", required=true,
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
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show($country)
    {
        $findedCountry = Country::find($country);
        if($findedCountry){
            return response(new CountryResource($findedCountry),200);
        }
        return response()->json($this->dataError,404);
    }

    /*
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(Country $country)
    {
        //
    }

    /*
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
        //
    }

    /*
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */

         /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Delete(
     * path="/v1/country/{country}",
     * summary="Get one and Delete related to country id",
     * description="Return  date related to ID of the country",
     * tags={"Country"},
     * 
     * *@OA\Parameter(name="country", in="path", description="put country id and try to delete ", required=true,
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

    public function destroy($country)
    {
        try{
            $c = Country::find($country);
            if($c){
                $c->delete();
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
     * path="/v1/countries/{country}/university",
     * summary="Get one with relation table universities , put country id and get universities ",
     * description="Return all date related to ID{country id}",
     * tags={"Country"},
     *  @OA\Parameter(name="country", in="path", description="ID of the country", required=true,
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

    public function university($country)
    {
        $findedCoun = Country::find($country);
        if($findedCoun){
            return response()->json(new CountryRelationResource($findedCoun),200);
        }
        return response()->json($this->dataError,404);
    }


    /**
     * * * * * *  * * * *  * * * * * *
     * @OA\Get(
     * path="/v1/option/country",
     * summary="Return only name and id for select option menu",
     * description="Return only name and id",
     * tags={"Country"},
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


    public function countryObject()
    {
        return  response()->json(Country::select('id','name')->get(),200);
    }

    
}
