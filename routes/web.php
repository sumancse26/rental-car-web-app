<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuthentication;
use Illuminate\Support\Facades\Route;


//page routes
Route::get('/', [CarController::class, 'dashboardList'])->name('home')->middleware(TokenAuthentication::class);
Route::get('car-list', [CarController::class, 'carList'])->name('car.list');
Route::get('add-car', [CarController::class, 'addCarToList'])->name('car.add');
Route::get('rental-list', [RentalController::class, 'rentalPage'])->name('rental.list');
Route::get('add-rental', [RentalController::class, 'addRentalPage'])->name('rental.add');
Route::get('add-user', [UserController::class, 'addUserPage'])->name('user.add');
Route::get('list-user', [UserController::class, 'listUserPage'])->name('user.list');
Route::get('login-page', [UserController::class, 'loginPage'])->name('auth.login');

//user routes
Route::post('user-registration', [UserController::class, 'createUser']);
Route::post('login', [UserController::class, 'login'])->name('user.login');
Route::get('logout', [UserController::class, 'logout']);
Route::post('edit-user', [UserController::class, 'editUser'])->middleware(TokenAuthentication::class);



//Car routes
Route::post('add-car', [CarController::class, 'addCar'])->middleware(TokenAuthentication::class);
Route::post('edit-car', [CarController::class, 'editCar'])->middleware(TokenAuthentication::class);
Route::get('get-car', [CarController::class, 'getCar'])->middleware(TokenAuthentication::class);
Route::delete('delete-car/{id}', [CarController::class, 'deleteCar'])->middleware(TokenAuthentication::class);

//Rentals routes
Route::post('create-update-rental', [RentalController::class, 'createOrUpdateRental'])->middleware(TokenAuthentication::class);
Route::get('get-rental', [RentalController::class, 'getRental'])->middleware(TokenAuthentication::class);
Route::get('cancel-rental', [RentalController::class, 'cancelRental'])->middleware(TokenAuthentication::class);
Route::delete('delete-rental', [RentalController::class, 'deleteRental'])->middleware(TokenAuthentication::class);
