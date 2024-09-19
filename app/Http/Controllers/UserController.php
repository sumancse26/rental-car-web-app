<?php

namespace App\Http\Controllers;

use App\Helpers\JWTToken;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function addUserPage()
    {
        return view('pages.auth.register');
    }
    public function listUserPage()
    {
        return view('pages.dashboard.user-list');
    }
    public function createUser(Request $request)
    {
        try {
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role') ?? 'customer',
            ]);
            return response()->json(['success' => 'User created successfully.'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function login(Request $request)
    {
        try {

            $user = User::where('email', $request->input('email'))->first();
            if ($user && Hash::check($request->input('password'), $user->password)) {
                $token = JWTToken::generateToken($user->email, $user->id);

                return response()->json(['success' => true, 'message' => 'User logged in successfully.'], 200)->cookie('token', $token, 60 * 24 * 30, '/');
            } else {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            return response()->json(['success' => true, 'message' => 'User logged out successfully.'], 200)->cookie('token', null, -1, '/');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Internal serve error'], 500);
        }
    }

    public function editUser(Request $request)
    {
        try {
            $userId = $request->header('id');

            $isExist = User::where('id', $userId)->first();
            if ($isExist == null) {
                return response()->json(['error' => 'Unauthorized'], 404);
            }

            $user = User::where('id', $request->input('id'))->first();

            $user->update([
                'name' => $request->input('name'),
                'password' => Hash::make($request->input('password')),
                'role' => $request->input('role') ?? 'customer',
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
            ]);
            return response()->json(['success' => 'User updated successfully.'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
