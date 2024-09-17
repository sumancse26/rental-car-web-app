<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuthentication;
use Illuminate\Support\Facades\Route;


Route::post('user-registration', [UserController::class, 'createUser']);
Route::post('login', [UserController::class, 'login']);
Route::get('logout', [UserController::class, 'logout']);

//Car routes
Route::post('add-car', [CarController::class, 'addCar'])->middleware(TokenAuthentication::class);
Route::post('edit-car', [CarController::class, 'editCar'])->middleware(TokenAuthentication::class);
Route::get('get-car', [CarController::class, 'getCar'])->middleware(TokenAuthentication::class);
Route::delete('delete-car/{id}', [CarController::class, 'deleteCar'])->middleware(TokenAuthentication::class);

//Rentals routes
Route::post('create-rental', [RentalController::class, 'createOrUpdateRental'])->middleware(TokenAuthentication::class);
