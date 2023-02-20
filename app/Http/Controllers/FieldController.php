<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Field;
use App\Models\University;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\File;

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
            'name'=>['required'],
            'category'=>['required'],
            'price'=>['required'],
            'duration'=>['required'],
            'description'=>['required'],
        ]);

        $field = new Field();
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
    public function edit($field)
    {
        $field = Field::find($field);
        $university = University::all();
        if($field){
            return view('field.update',[
                'field'=>$field,
                'university'=>$university
            ]);
           }
           return redirect()->route('field.web.index')->with('errors', 'Not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$field)
    {
        $field = Field::find($field);
        if($field){
        $field->university_id = $request->university_id ?? $field->university_id;
        $field->name = $request->name ?? $field->name;
        $field->category = $request->category ?? $field->category ;
        $field->price = $request->price ?? $field->price;
        $field->duration = $request->duration ?? $field->duration;
        $field->description = $request->description ?? $field->description;
        $field->save();
        return redirect()->route('field.web.index')->with('success', ' A new field  added');
        }
        return redirect()->route('field.web.index')->with('errors', 'Not found');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Field  $field
     * @return \Illuminate\Http\Response
     */
    public function destroy($field)
    {
        
        try{
            // dd($university);
            $field = Field::find($field);
            if($field){
                $file = File::exists(public_path($field->image));
                if($file){
                    File::delete(public_path($field->image));
                    $field->delete();
                    return redirect()->route('field.web.index')->with('success', ' Deleted');
                }
                $field->delete();
                return redirect()->route('field.web.index')->with('success', ' Deleted');
            }
            return redirect()->route('field.web.index')->with('errors', 'Not found');
        }catch(Exception $e){
        return redirect()->route('field.web.index')->with('errors', 'Can not be deleted becouse it is connected to field');
       }
    }
}
