<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{
    public function addCar(Request $request)
    {
        try {
            $userId = $request->header('id');


            $user = User::where('id', $userId)->first();
            if ($user == null || $user->role != 'admin') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
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
                'availability' => $request->input('availability'),
                'image' => $img_url

            ]);
            return response()->json(['success' => true, 'message' => 'Car added successfully.'], 200);
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

            $car = Car::where('id', $request->input('id'))->first();
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
                File::delete($filePath);

                $car->name = $request->input('name');
                $car->brand = $request->input('brand');
                $car->model = $request->input('model');
                $car->year = $request->input('year');
                $car->car_type = $request->input('car_type');
                $car->daily_rent_price = $request->input('daily_rent_price');
                $car->availability = $request->input('availability');
                $car->image = $img_url;
            } else {
                $car->name = $request->input('name');
                $car->brand = $request->input('brand');
                $car->model = $request->input('model');
                $car->year = $request->input('year');
                $car->car_type = $request->input('car_type');
                $car->daily_rent_price = $request->input('daily_rent_price');
                $car->availability = $request->input('availability');
            }

            $car->save();

            return response()->json(['success' => true, 'message' => 'Car updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getCar(Request $request)
    {
        try {
            $userId = $request->header('id');

            $user = User::where('id', $userId)->first();
            if ($user == null) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::all();
            return response()->json(['success' => true, 'car' => $car], 200);
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
            File::delete($filePath);
            $car->delete();
            return response()->json(['success' => true, 'message' => 'Car deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
