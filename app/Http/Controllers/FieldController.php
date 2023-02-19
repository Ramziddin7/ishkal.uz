<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Field;
use App\Models\University;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $field = Field::all();
        return view('field.index',[
            'fields'=>$field
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $university = University::all();
        $country = Country::all();
        return view('field.create',[
            'university'=>$university,
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
        return redirect()->route('field.web.index')->with('success', ' A new field  added');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        //
    }
}
