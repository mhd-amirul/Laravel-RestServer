<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class profileController extends Controller
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

    public function updateAccount(Request $request)
    {
        $db = User::where('id', $request->id)->first();
        if ($db) {
            $data = $request->all();
            $rules = [];
            if ($data['name'] || $data['name'] != $db['name']) {
                $rules['name'] = 'required|min:6';
            }
            if ($data['email'] || $data['email'] != $db['email']) {
                $rules['email'] = 'required|email|unique:users,email';
            }

            $val = $this->validationInput($data, $rules);
            if ($val['status'] == false) {
                return response()->json($val['message'], 422);
            }

            $db->update($data);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Update have been Successfully',
                    'item' => $db
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User not Found'
                ], 404
            );
        }
    }

    public function resetPass(Request $request)
    {
        $db = User::where('id', $request->id)->first();
        if ($db) {
            $data = $request->all();
            $rules = [
                'password' => 'required|min:5',
                'newPass' => 'required|min:5',
                'confirmPass' => 'required|same:newPass'
            ];
            $val = $this->validationInput($data, $rules);
            if ($val['status'] == false) {
                return response()->json($val['message'], 422);
            }

            if (!Hash::check($data['password'], $db['password'])) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Invalid Password'
                    ], 400
                );
            }

            $data['password'] = Hash::make($data['newPass']);
            $db->update($data);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Password have been reset',
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User not Found'
                ], 404
            );
        }
    }
}
