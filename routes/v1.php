<?php

use Illuminate\Support\Facades\Route;


Route::post('refresh',[\App\Http\Controllers\API\v1\AuthController::class,'refresh']);
Route::post('logout',[\App\Http\Controllers\API\v1\AuthController::class,'logout']);
Route::post('register',[\App\Http\Controllers\API\v1\AuthController::class,'register']);
Route::post('login',[\App\Http\Controllers\API\v1\AuthController::class,'login']);

Route::get('countries/{country}/university',[App\Http\Controllers\API\v1\CountryController::class,'university']);
Route::resource('country',CountryController::class);


Route::get('universities/{university}/field',[App\Http\Controllers\API\v1\UniversityController::class,'field']);
Route::resource('university',UniversityController::class);



Route::get('fields/{field}/field',[App\Http\Controllers\API\v1\FieldController::class,'getAllTheRelation']);
Route::resource('field',FieldController::class);
