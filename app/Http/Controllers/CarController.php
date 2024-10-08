<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{

    //methods for page routes
    public function addCarToList(Request $request)
    {

        return view('pages.dashboard.add-car');
    }

    public function carPage(Request $request)
    {
        $cars = Car::where('availability', 1)->get();
        return view('pages.frontend.car-page', ['cars' => $cars]);
    }

    public function dashboardList(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::where('id', $userId)->first();

            if ($user == null) {
                return redirect(route('auth.login'));
            }
            if ($user->role != 'admin') {
                return redirect(route('home'));
            }

            $cars = Car::all();
            $rentals = Rental::all();

            $totalCars = $cars->count();
            $availableCars = $cars->where('availability', '1')->count();

            $totalRentals = $rentals->count();
            $totalOngoingRentals = Rental::where('status', 'ongoing')->count();
            $totalCanceledRentals = Rental::where('status', 'cancelled')->count();
            $totalCompletedRentals = Rental::where('status', 'completed')->count();
            $totalEarnings = Rental::where('status', 'completed')->sum('total_cost');


            return view('pages.dashboard.dashboard', ['totalCars' => $totalCars, 'availableCars' => $availableCars, 'totalRentals' => $totalRentals, 'totalOngoingRentals' => $totalOngoingRentals, 'totalCanceledRentals' => $totalCanceledRentals, 'totalCompletedRentals' => $totalCompletedRentals, 'totalEarnings' => $totalEarnings]);
        } catch (\Exception $ex) {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage()
            ]);
        }
    }

    public function addCar(Request $request)
    {
        try {
            $userId = $request->header('id');

            $user = User::where('id', $userId)->first();
            if ($user == null || $user->role != 'admin') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            if (!$request->hasFile('image')) {
                return response()->json(['success' => false, 'message' => 'Image file is required.'], 400);
            }

            $img = $request->file('image');

            $imgName = $img->getClientOriginalName();
            $time = time();
            $uploadedImg = $userId . $time . $imgName;

            $img->move(public_path('uploads'), $uploadedImg);

            $img_url = "uploads/{$uploadedImg}";

            $car = Car::create([
                'name' => $request->input('name'),
                'brand' => $request->input('brand'),
                'model' => $request->input('model'),
                'year' => $request->input('year'),
                'car_type' => $request->input('car_type'),
                'daily_rent_price' => $request->input('daily_rent_price'),
                'availability' => $request->input('availability') ?? 0,
                'image' => $img_url
            ]);

            return redirect('get-car');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function editCar(Request $request)
    {
        try {

            $userId = $request->header('id');
            $user = User::where('id', $userId)->first();
            if ($user == null || $user->role != 'admin') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
            $car = Car::where('id', $request->id)->first();
            if ($car == null) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }

            if ($request->hasFile('image')) {
                $img = $request->file('image');
                $imgName = $img->getClientOriginalName();
                $time = time();
                $uploadedImg = $userId . $time . $imgName;
                $img->move(public_path('uploads'), $uploadedImg);

                $img_url = "uploads/{$uploadedImg}";

                $filePath = $car->image;
                File::delete(public_path($filePath));

                $car->name = $request->input('name');
                $car->brand = $request->input('brand');
                $car->model = $request->input('model');
                $car->year = $request->input('year');
                $car->car_type = $request->input('car_type');
                $car->daily_rent_price = $request->input('daily_rent_price');
                $car->availability = $request->input('availability') ?? 0;
                $car->image = $img_url;
            } else {
                $car->name = $request->input('name');
                $car->brand = $request->input('brand');
                $car->model = $request->input('model');
                $car->year = $request->input('year');
                $car->car_type = $request->input('car_type');
                $car->daily_rent_price = $request->input('daily_rent_price');
                $car->availability = $request->input('availability') ?? 0;
            }

            $car->save();

            return redirect('get-car');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCar(Request $request)
    {
        try {
            $car = Car::where('availability', 1)->get();
            return view('pages.dashboard.car-list', ['cars' => $car]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCarById(Request $request)
    {
        try {
            $userId = $request->header('id');

            $user = User::where('id', $userId)->first();
            if ($user == null) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::find($request->id);

            if ($car == null) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }
            return view('pages.dashboard.edit-car', ['car' => $car]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteCar(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::where('id', $userId)->first();
            if ($user == null || $user->role != 'admin') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::where('id', $request->id)->first();
            if ($car == null) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }

            $filePath = $car->image;
            File::delete(public_path($filePath));
            $car->delete();
            return redirect('get-car');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
