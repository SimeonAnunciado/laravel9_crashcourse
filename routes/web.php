<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// all listing
Route::get('/', [ListingController::class,'index']);


Route::group(['prefix'=>'listings'], function(){

        //show create form
    Route::get('/create', [ListingController::class,'create'])->middleware('auth');
    // POST store data
    Route::post('/store', [ListingController::class,'store'])->middleware('auth');

    // Manage Listings
    Route::get('/manage',[ListingController::class,'manage'])->middleware('auth');

    //single listing
    Route::get('/{listing}', [ListingController::class,'show']);

    // show edit form
    Route::get('/{listing}/edit', [ListingController::class,'edit'])->middleware('auth');
    // update edit
    Route::put('/{listing}', [ListingController::class,'update'])->middleware('auth');;
    // delete listing
    Route::delete('/{listing}', [ListingController::class,'delete'])->middleware('auth');;

   
});





//show register create form
Route::get('/register',[UserController::class,'create'])->middleware('guest');
Route::post('/users',[UserController::class,'store']);
Route::get('/login',[UserController::class,'login'])->name('login')->middleware('guest');;
Route::post('/logout',[UserController::class,'logout'])->middleware('auth');
// login User
Route::post('/users/authenticate',[UserController::class,'authenticate']);


