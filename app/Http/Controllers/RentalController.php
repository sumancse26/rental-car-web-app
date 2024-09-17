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
    public function createOrUpdateRental(Request $request)
    {
        DB::beginTransaction();

        try {
            // Fetch user from header
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
}
