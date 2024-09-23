<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenAuthentication;
use Illuminate\Support\Facades\Route;



//backend page routes

Route::get('dashboard', [CarController::class, 'dashboardList'])->middleware(TokenAuthentication::class)->name('dashboard');
Route::get('add-car', [CarController::class, 'addCarToList'])->name('car.add');
Route::get('add-rental', [RentalController::class, 'addRentalPage'])->middleware(TokenAuthentication::class)->name('rental.addPage');
Route::get('add-user', [UserController::class, 'addUserPage'])->name('user.add');
Route::get('edit-user-page/{id}', [UserController::class, 'editUserPage'])->name('user.editPage');
Route::get('list-user', [UserController::class, 'listUserPage'])->middleware(TokenAuthentication::class)->name('user.list');
Route::get('login-page', [UserController::class, 'loginPage'])->name('auth.login');

//frontend page routes
Route::get('/', [UserController::class, 'homePage'])->name('home');
Route::get('car', [CarController::class, 'carPage'])->name('frontend.car');
Route::get('rental', [RentalController::class, 'rentalPage'])->name('frontend.rentals');
Route::get('booking', [RentalController::class, 'bookingPage'])->middleware(TokenAuthentication::class)->name('frontend.bookings');

//user routes
Route::post('user-registration', [UserController::class, 'createUser']);
Route::post('login', [UserController::class, 'login'])->name('user.login');
Route::get('logout', [UserController::class, 'logout'])->name('user.logout');
Route::post('edit-user/{id}', [UserController::class, 'editUser'])->middleware(TokenAuthentication::class)->name('user.update');



//Car routes
Route::post('add-car', [CarController::class, 'addCar'])->middleware(TokenAuthentication::class)->name('add.car');
Route::post('edit-car/{id}', [CarController::class, 'editCar'])->middleware(TokenAuthentication::class)->name('edit.car');
Route::get('get-car', [CarController::class, 'getCar'])->name('car.list');
Route::delete('delete-car/{id}', [CarController::class, 'deleteCar'])->middleware(TokenAuthentication::class)->name('car.delete');
Route::get('get-car/{id}', [CarController::class, 'getCarById'])->middleware(TokenAuthentication::class)->name('car.edit.page');

//Rentals routes
Route::post('create-update-rental/{id?}', [RentalController::class, 'createOrUpdateRental'])->middleware(TokenAuthentication::class)->name('rental.add');
Route::get('get-rental', [RentalController::class, 'getRental'])->middleware(TokenAuthentication::class)->name('rental.list');
Route::get('cancel-rental/{id}', [RentalController::class, 'cancelRental'])->middleware(TokenAuthentication::class)->name('rental.cancel');
Route::get('complete-rental/{id}', [RentalController::class, 'completeRental'])->middleware(TokenAuthentication::class)->name('rental.complete');
Route::delete('delete-rental', [RentalController::class, 'deleteRental'])->middleware(TokenAuthentication::class);
Route::get('get-rental-by-id/{id}', [RentalController::class, 'getRentalById'])->middleware(TokenAuthentication::class)->name('rental.edit');
Route::get('get-rental-by-car/{id}', [RentalController::class, 'getRentalByCar'])->middleware(TokenAuthentication::class)->name('rental.bycar');
