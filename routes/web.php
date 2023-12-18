<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Listing;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//get all
Route::get('/', [ListingController::class, 'index']);


// Show Create Form
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');


//store
Route::post('/listings/', [ListingController::class, 'store'])->middleware('auth');

//show edit form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//submit edit form
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//delete listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

//manage listings
Route::get('/listings/manage', [ListingController::Class, 'manage'])->middleware('auth');

//single
Route::get('/listings/{listing}', [ListingController:: class, 'show']);

//show register form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

//create user
Route::post('/users', [UserController::class, 'store']);

//logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

//show login form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

//log in user
Route::post('/users/authenticate', [UserController::Class, 'authenticate']);
