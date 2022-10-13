<?php

namespace App\Http\Controllers\auth;

use App\Events\sendMailEvent;
use App\Http\Controllers\Controller;
use App\Models\otpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class authentikasiController extends Controller
{
    public function validationInput($data, $rules)
    {
        $val = Validator::make($data, $rules);
        if ($val->fails()) {
            return
            [
                'status' => false,
                'message' => $val->errors()
            ];
        } else {
            return ['status' => true];
        }
    }

    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirmPass' => 'required|same:password'
        ];

        $user = $request->all();
        $val = $this->validationInput($user, $rules);
        if ($val['status'] == false) {
            return response()->json($val, 422);
        }

        $user['password'] = Hash::make($user['password']);
        $user['otp'] = rand(0001, 9999);
        $data = User::create($user);
        otpCode::create($user);
        sendMailEvent::dispatch($user);
        return response()->json(
            [
                'status' => "OK",
                'data' => $data
            ], 200
        );
    }

    public function signin(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $data = $request->all();
        $val = $this->validationInput($data, $rules);
        if ($val['status'] == false) {
            return response()->json($val, 422);
        }

        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user['password'])) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Sign In failed',
                    'item' => $data
                ], 400
            );
        }

        $token = $user->createToken('token')->plainTextToken;
        return response()->json(
            [
                'status' => true,
                'message' => 'Sign In Successfully',
                'token' => $token,
                'item' => $user
            ], 200
        );
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
