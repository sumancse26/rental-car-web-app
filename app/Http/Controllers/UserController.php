<?php

namespace App\Http\Controllers;

use App\Helpers\JWTToken;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function homePage(Request $request)
    {
        $car = Car::where('availability', 1)->get();
        return view('pages.frontend.home-page', ['cars' => $car]);
    }
    public function loginPage()
    {
        return view('pages.auth.login');
    }
    public function addUserPage()
    {
        return view('pages.auth.register');
    }
    public function editUserPage(Request $request, $id)
    {

        $selectedUserInfo = User::where('id', $id)->first();
        return view('pages.dashboard.user-edit', ['user' => $selectedUserInfo]);
    }


    public function listUserPage()
    {
        try {

            $users = User::all();

            return view('pages.dashboard.user-list', ['users' => $users]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
                return redirect('/')->withCookie(cookie('token', $token, 60 * 24 * 30, '/',));
            } else {
                return response()->json(['success' => false, 'error' => 'Invalid',  'message' => 'Unauthorized'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            return redirect('/')->withCookie('token', null, -1, '/');
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Internal serve error'], 500);
        }
    }

    public function editUser(Request $request, $id)
    {
        try {
            $userId = $request->header('id');

            $isExist = User::where('id', $userId)->first();
            if ($isExist == null) {
                return response()->json(['error' => 'Unauthorized'], 404);
            }

            $user = User::where('id', $id)->first();

            $role = $request->input('role') == '1' ? 'admin' :  'customer';

            $user->update([
                'name' => $request->input('name'),
                'role' => $role,
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
            ]);
            return redirect(route('user.list'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
