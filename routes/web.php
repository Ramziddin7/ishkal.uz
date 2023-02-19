<?php

use App\Http\Controllers\AuthWebController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('home');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// country
Route::get('country', [CountryController::class,'index'])->name('country.web.index');
Route::get('country/create', [CountryController::class,'create'])->name('country.web.create');
Route::post('country/store/create', [CountryController::class,'store'])->name('country.web.store');
Route::get('country/edit/{id}', [CountryController::class,'edit'])->name('country.web.edit');
Route::put('country/update/{id}', [CountryController::class,'update'])->name('country.web.update');
Route::delete('country/delete/{id}', [CountryController::class,'destroy'])->name('country.web.delete');

// University
Route::get('university', [UniversityController::class,'index'])->name('university.web.index');
Route::get('university/create', [UniversityController::class,'create'])->name('university.web.create');
Route::post('university/store/create', [UniversityController::class,'store'])->name('university.web.store');
Route::get('university/edit/{id}', [UniversityController::class,'edit'])->name('university.web.edit');
Route::put('university/update/{id}', [UniversityController::class,'update'])->name('university.web.update');
Route::delete('university/delete/{id}', [UniversityController::class,'destroy'])->name('university.web.delete');

// field
Route::get('field', [FieldController::class,'index'])->name('field.web.index');
Route::get('field/create', [FieldController::class,'create'])->name('field.web.create');
Route::post('field/store/create', [FieldController::class,'store'])->name('field.web.store');
Route::get('field/edit/{id}', [FieldController::class,'edit'])->name('field.web.edit');
Route::put('field/update/{id}', [FieldController::class,'update'])->name('field.web.update');
Route::delete('field/delete/{id}', [FieldController::class,'destroy'])->name('field.web.delete');

//  auth

Route::get('dashboard', [AuthWebController::class, 'dashboard']); 
Route::get('login', [AuthWebController::class, 'index'])->name('login');
Route::post('custom-login', [AuthWebController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [AuthWebController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [AuthWebController::class, 'customRegistration'])->name('register.custom'); 
Route::get('signout', [AuthWebController::class, 'signOut'])->name('signout');




Route::middleware('guest')->group(function () {
    Route::get('login',[\App\Http\Controllers\AuthWebController::class,'index']);
    Route::post('login',[\App\Http\Controllers\AuthWebController::class,'login']);
});
Route::middleware('auth')->group(function () {
    Route::post('register',[\App\Http\Controllers\AuthWebController::class,'register']);
    Route::post('logout',[\App\Http\Controllers\AuthWebController::class,'logout']);
});