<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\University;
use Illuminate\Http\Request;

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
            'contractFile'=>['required','mimes:pdf,xlxs,xlx,docx,doc,csv,txt|max:4096'],
            'name'=>['required'],
            'min_price'=>['required'],
            'min_ielts'=>['required'],
            'city_name'=>['required'],
            'image'=>['required','mimes:jpeg,png,jpg'],
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
            $univer->categories = $request->categories;
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
    public function edit(University $university)
    {
        //
    }

    /**
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\University  $university
     * @return \Illuminate\Http\Response
     */
    public function destroy(University $university)
    {
        //
    }
}
