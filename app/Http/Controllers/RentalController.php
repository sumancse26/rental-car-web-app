<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Rental;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    public function rentalPage()
    {
        return redirect(route('frontend.car'));
    }

    public function bookingPage(Request $request)
    {
        $userId = $request->header('id');
        $user = User::find($userId);
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 404);
        }

        $booking = Rental::where('user_id', $userId)
            ->with('car', 'user')
            ->get();

        return view('pages.frontend.booking-page', ['bookings' => $booking]);
    }
    public function addRentalPage(Request $request)
    {
        $userId = $request->header('id');

        $user = User::where('id', $userId)->first();
        if ($user == null) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }


        $car = Car::where('availability', 1)->get();
        return view('pages.dashboard.add-rental', ['cars' => $car]);
    }
    public function createOrUpdateRental(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = json_decode($request->selected_car);
            $car_id = $data->id;

            $userId = $request->header('id');
            $user = User::find($userId);
            $carId =  $car_id;

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::where('id', $carId)->first();

            if (!$car) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }
            $rental = Rental::where('id', $id)->first();

            if ($rental && $userId != $rental->user_id && $car->availability === 0) {
                return response()->json(['success' => false, 'message' => 'Car is not available'], 400);
            }

            if ($rental) {
                $prevCar = Car::where('id', $rental->car_id)->first();
                $prevCar->availability = 1;
                $prevCar->save();
            }

            $car->availability = 0;
            $car->save();

            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $days = $startDate->diffInDays($endDate) + 1;
            $totalCost = $car->daily_rent_price * $days;

            $data = Rental::updateOrCreate(
                [
                    'id' => $id,
                ],
                [
                    'user_id' => $userId,
                    'car_id' => $carId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $request->input('status', 'ongoing'),
                    'total_cost' => $totalCost,
                ]
            );

            DB::commit();

            return redirect(route('rental.list'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createOrUpdateRentalFromFrontend(Request $request, $id = null)
    {
        DB::beginTransaction();

        try {
            $data = json_decode($request->selected_car);

            $car_id = $data->id;

            $userId = $request->header('id');
            $user = User::find($userId);

            $carId = $request->input('car_id') ?? $car_id;

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::where('id', $carId)->first();

            if (!$car) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }
            $rental = Rental::where('car_id', $carId)->first();

            if ($rental && $userId != $rental->user_id && $car->availability === 0) {
                return response()->json(['success' => false, 'message' => 'Car is not available'], 400);
            }



            $car->availability = 0;
            $car->save();


            $startDate = Carbon::parse($request->input('start_date'));
            $endDate = Carbon::parse($request->input('end_date'));
            $days = $startDate->diffInDays($endDate) + 1;
            $totalCost = $car->daily_rent_price * $days;

            $data = Rental::updateOrCreate(
                [
                    'id' => $id,
                ],
                [
                    'user_id' => $userId,
                    'car_id' => $carId,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $request->input('status', 'ongoing'),
                    'total_cost' => $totalCost,
                ]
            );

            DB::commit();

            return redirect(route('frontend.bookings'));
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getRental(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }

            $booking = Rental::where('user_id', $userId)
                ->with('car', 'user')
                ->get();

            return view('pages.dashboard.rental-list', ['bookings' => $booking]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function getRentalById(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }
            $rental = Rental::where('car_id', $request->id)->with('car')->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }

            $car = Car::where('id', $request->id)
                ->orWhere('availability', 1)->get();

            return view('pages.dashboard.edit-rental', ['rental' => $rental, 'cars' => $car]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function getRentalByCar(Request $request, $id)
    {
        try {
            $car = Car::where('availability', 1)->get();
            $selectedCar = Car::where('id', $id)->first();
            return view('pages.frontend.add-rental', ['cars' => $car, 'selectedCar' => $selectedCar]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteRental(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user && $user->role != 'admin') {
                return response()->json(['message' => 'Unauthorized'], 404);
            }

            $rental = Rental::where('id', $request->id)->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }
            $car = Car::where('id', $rental->car_id)->first();
            if (!$car) {
                return response()->json(['message' => 'Car not found'], 404);
            }
            $car->availability = 1;
            $car->save();
            $rental->delete();
            return response()->json(['success' => true, 'message' => 'Rental deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function cancelRental(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }

            $rental = Rental::where('id', $request->id)->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }
            $car = Car::where('id', $rental->car_id)->first();
            if (!$car) {
                return response()->json(['message' => 'Car not found'], 404);
            }
            $car->availability = 1;
            $car->save();
            $rental->status = 'cancelled';
            $rental->save();
            return redirect(route('rental.list'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function cancelRentalFromFrontend(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }

            $rental = Rental::where('id', $request->id)->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }
            $car = Car::where('id', $rental->car_id)->first();
            if (!$car) {
                return response()->json(['message' => 'Car not found'], 404);
            }
            $car->availability = 1;
            $car->save();
            $rental->status = 'cancelled';
            $rental->save();
            return redirect(route('frontend.bookings'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function completeRental(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }
            $rental = Rental::where('id', $request->id)->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }

            $car = Car::where('id', $rental->car_id)->first();
            if (!$car) {
                return response()->json(['message' => 'Car not found'], 404);
            }
            $car->availability = 1;
            $car->save();

            $rental->status = 'completed';
            $rental->save();
            return redirect(route('rental.list'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function completeRentalFromFrontend(Request $request)
    {
        try {
            $userId = $request->header('id');
            $user = User::find($userId);
            if (!$user) {
                return response()->json(['message' => 'Unauthorized'], 404);
            }
            $rental = Rental::where('id', $request->id)->first();
            if (!$rental) {
                return response()->json(['message' => 'Rental not found'], 404);
            }

            $car = Car::where('id', $rental->car_id)->first();
            if (!$car) {
                return response()->json(['message' => 'Car not found'], 404);
            }
            $car->availability = 1;
            $car->save();

            $rental->status = 'completed';
            $rental->save();
            return redirect(route('frontend.bookings'));
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
