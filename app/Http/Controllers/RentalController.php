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
        return view('pages.dashboard.rental-list');
    }
    public function addRentalPage()
    {
        return view('pages.dashboard.add-rental');
    }
    public function createOrUpdateRental(Request $request)
    {
        DB::beginTransaction();

        try {
            $userId = $request->header('id');
            $user = User::find($userId);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }

            $car = Car::where('id', $request->input('car_id'))->first();
            if (!$car) {
                return response()->json(['success' => false, 'message' => 'Car not found'], 404);
            }
            $rental = Rental::where('car_id', $request->input('car_id'))->first();

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
                    'user_id' => $userId,
                    'car_id' => $request->input('car_id'),
                ],
                [
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $request->input('status', 'ongoing'),
                    'total_cost' => $totalCost,
                ]
            );

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Rental created/updated successfully', 'rental' => $data], 200);
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
                ->with('car')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $booking
            ]);
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
            return response()->json(['success' => true, 'message' => 'Rental canceled'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
