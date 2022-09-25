<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class profileController extends Controller
{
    public function updateAccount(Request $request)
    {
        $rules = [
            'name' => 'required|min:6',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5',
            'confirmPass' => 'required|same:password'
        ];
    }
}
