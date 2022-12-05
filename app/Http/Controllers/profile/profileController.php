<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\resetPasswordRequest;
use App\Http\Requests\updateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class profileController extends Controller
{
    public function updateAccount(updateUserRequest $request)
    {
        $db = User::where("email", auth()->user()->email)->first();
        if ($db) {
            $data = $request->all();
            $db->update($data);
            return response()->json([
                "message" => "User information have been update",
                "data" => $db
            ], 200 );
        } else {
            return response()->json([ "message" => "User not Found" ], 404 );
        }
    }

    public function resetPass(resetPasswordRequest $request)
    {
        $db = User::where("email", auth()->user()->email)->first();
        if ($db) {
            $data = $request->all();
            if (Hash::check($data["oldPass"], $db["password"])) {
                $data["password"] = Hash::make($data["password"]);
                $db->update($data);
                return response()->json([
                    "message" => "Password have been updated",
                ], 200 );
            } else {
                return response()->json([ "message" => "Invalid Password" ], 400 );
            }
        } else {
            return response()->json([ "message" => "User not Found" ], 404 );
        }
    }
}
