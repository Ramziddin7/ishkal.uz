<?php
use App\Http\Controllers\CountryController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\UniversityController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


    Route::get('/', [App\Http\Controllers\LoginController::class, 'show']);


    Route::group(['middleware' => ['guest']], function() {
       
        Route::get('worluzrustamovramziddin', [\App\Http\Controllers\RegisterController::class, 'show'])->name('show.register');
        Route::post('reg',[\App\Http\Controllers\RegisterController::class, 'register'])->name('store.register');

        Route::get('log', [\App\Http\Controllers\LoginController::class ,'show'])->name('login.show');
        Route::post('log', [\App\Http\Controllers\LoginController::class,'login'])->name('login.perform');
    });

        Route::group(['middleware' => ['auth']], function() {
       // country
        Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

        Route::get('country', [CountryController::class,'index'])->name('country.web.index');
        Route::get('country/create', [CountryController::class,'create'])->name('country.web.create');
        Route::post('country/store/create', [CountryController::class,'store'])->name('country.web.store');
        Route::get('country/edit/{id}', [CountryController::class,'edit'])->name('country.web.edit');
        Route::put('country/update/{id}', [CountryController::class,'update'])->name('country.web.update');
        Route::delete('country/delete/{id}', [CountryController::class,'destroy'])->name('country.web.delete');

        // University
        Route::get('university', [UniversityController::class,'index'])->name('university.web.index');
        // Route::get('dowloadcontract/file/{id}', [UniversityController::class,'download']);
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

        Route::get('logout', [\App\Http\Controllers\LogoutController::class,'perform'])->name('logout.perform');

        });



  