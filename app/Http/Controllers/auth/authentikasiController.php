<?php

namespace App\Http\Controllers\auth;

use App\Events\sendMailEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\loginRequest;
use App\Http\Requests\registerRequest;
use App\Models\otpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authentikasiController extends Controller
{
    public function signup(registerRequest $request)
    {
        $user = $request->all();
        $user['password'] = Hash::make($user['password']);
        $user['otp'] = rand(0001, 9999);
        $data = User::create($user);
        // otpCode::create($user);
        // sendMailEvent::dispatch($user);
        return response()->json(
            [
                'message' => "Sign Up Successfully",
                'data' => $data
            ], 200
        );
    }

    public function signin(loginRequest $request)
    {
        $data = $request->all();
        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user['password'])) {
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'Sign In Successfully',
                'token' => $token,
                'item' => $user
            ], 200 );
        } else {
            return response()->json([ 'message' => 'Sign In failed', ], 400 );
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Sign Out Successfully'
        ], 200);
    }
}
