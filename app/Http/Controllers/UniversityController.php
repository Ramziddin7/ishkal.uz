<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\University;
use Illuminate\Http\Request;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Support\Facades\File;


class UniversityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $universities = University::all();
        return view('university.index',[
            'universities'=>$universities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $country = Country::all();
        return view('university.create',[
            'country'=>$country
        ]);
    }

    /**
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
            'contractFile'=>['required','mimes:pdf,xlxs,xlx,docx,doc,csv,txt|max:8192'],
            'name'=>['required'],
            'min_price'=>['required'],
            'min_ielts'=>['required'],
            'city_name'=>['required'],
            'image'=>['required','mimes:jpeg,png,jpg,webp'],
        ]);


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
            $univer->country_id = $request->country_id;
            $univer->categories = json_encode($request->categories);
            $univer->image = $imagePath;
            $univer->contractFile = $filePath;
            $univer->name = $request->name;
            $univer->min_price = $request->min_price;
            $univer->min_ielts = $request->min_ielts;
            $univer->city_name = $request->city_name;
            $univer->save();
             return redirect()->route('university.web.index')->with('success', ' A new university added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function show(University $university)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function edit($university)
    {
        $university = University::find($university);
        $country = Country::all();
        if($university){
         return view('university.update',[
             'university'=>$university,
             'country'=>$country,
         ]);
        }
        return redirect()->route('university.web.index')->with('errors', 'Not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $university)
    {

        $request->validate([
            'image'=>['nullable','mimes:jpeg,png,jpg,webp'],
        ]);

        $university = University::find($university);
        if($university){
            if($request->file('image')){
                $getImage = $request->file('image');
                $imageName = $getImage->getClientOriginalName();
                $imageFullName = time().''. $imageName;
                $imageFullName = str_replace([' '],[''],$imageFullName);
                $imagePath = $getImage->move(('images'),$imageFullName);
            }
            if($request->file('contractFile')){
                    $fileGet = $request->file('contractFile');
                    $fileName = $request->contractFile->getClientOriginalName();
                    $fileFullName = time().''. $fileName;
                    $fileName = str_replace([' '],[''],$fileFullName);
                    $filePath = $fileGet->move(('uploads'),$fileName);
                
              }
            //   dd($university->country_id);
                $university->country_id = $request->country_id ?? $university->country_id;
                $university->categories = json_encode($request->categories) ?? $university->categories;
                $university->image = $imagePath ?? $university->image;
                $university->contractFile = $filePath ?? $university->contractFile;
                $university->name = $request->name ?? $university->name;
                $university->min_price = $request->min_price ?? $university->price;
                $university->min_ielts = $request->min_ielts ?? $university->ielts;
                $university->city_name = $request->city_name ?? $university->city_name;
                $university->save();
                return redirect()->route('university.web.index')->with('success', 'Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy($university)
    {
        try{
            // dd($university);
            $university = University::find($university);
            if($university){
                $file = File::exists(public_path($university->image));
                if($file){
                    File::delete(public_path($university->image));
                    $university->delete();
                    return redirect()->route('university.web.index')->with('success', ' Deleted');
                }
                $university->delete();
                return redirect()->route('university.web.index')->with('success', ' Deleted');
            }
            return redirect()->route('university.web.index')->with('errors', 'Not found');
        }catch(Exception $e){
        return redirect()->route('university.web.index')->with('errors', 'Can not be deleted becouse it is connected to field');
       }
    }


    // public function dowload($id){
    //     $uni = University::find($id);
    //     if($uni){
    //         $file = public_path().$uni->contractFile;
    //         $headers = [
    //             'Content-Type : application/pdf'
    //         ];

    //         return response()->download($$file, 'World uz contract with University', $headers);
    //     }
    // }
}
