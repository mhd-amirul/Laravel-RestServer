<?php

namespace App\Http\Controllers\mail;

use App\Http\Controllers\Controller;
use App\Mail\mailNotify;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class mailController extends Controller
{
    public function index()
    {
        $data = [
            'subject' => 'Hello World',
            'title' => 'Verify Your Account',
            'body' => 'Please verify your email',
            'sub_body' => 'Amazing deals, updates, interesting news right in your inbox',
            'nm_link' => 'Click Here!',
            'value_link' => '#',
        ];

        try {
            Mail::to('lohsu86@gmail.com')->send(new mailNotify($data));
            return response()->json(['OK']);
        } catch (Exception $th) {
            return response()->json(['BAD_REQUEST']);
        }
    }
}
