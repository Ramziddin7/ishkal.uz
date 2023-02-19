<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\File;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $country = Country::all();
        return view('country.index',[
            'country'=>$country
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('country.create');
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
        return redirect()->route('country.web.index')->with('success', ' A new country added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit($country)
    {
        $country = Country::find($country);
       if($country){
        return view('country.update',[
            'country'=>$country
        ]);
       }
       return redirect()->route('country.web.index')->with('errors', 'Not found');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$country)
    {
        
        $country = Country::find($country);
        if($country){
            if($request->file('image')){
                $getImage = $request->file('image');
                $imageName = $getImage->getClientOriginalName();
                $imageFullName = time().''. $imageName;
                $imageFullName = str_replace([' '],[''],$imageFullName);
                $path = $getImage->move(('images'),$imageFullName);
            }
            $country->name = $request->name;
            $country->image = $path ?? $country->image;
            $country->save();
            return redirect()->route('country.web.index')->with('success', ' Country updated');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy($country)
    {

        try{
            $country = Country::find($country);
            if($country){
                $file = File::exists(public_path($country->image));
                if($file){
                    File::delete(public_path($country->image));
                    $country->delete();
                    return redirect()->route('country.web.index')->with('success', ' Deleted');
                }
                $country->delete();
                return redirect()->route('country.web.index')->with('success', ' Deleted');
            }
            return redirect()->route('country.web.index')->with('errors', 'Not found');
        }catch(Exception $e){
        return redirect()->route('country.web.index')->with('errors', 'Can not be deleted becouse it is connected to university');
       }
    }
}
