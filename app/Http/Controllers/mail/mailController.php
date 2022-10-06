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
            'title' => 'Sample Test',
            'body' => 'Here is a very simple card. It has responsive padding so it gets less padding on mobile to fill the screen more. Hopefully it can be useful to you. It is very simple and basic but can be used for a lot of simple emails.',
            'nm_link' => 'Visit Website',
            'value_link' => 'https://app.bootstrapemail.com/templates',
            'img' => 'https://assets.bootstrapemail.com/logos/light/square.png'
        ];

        try {
            Mail::to('lohsu86@gmail.com')->send(new mailNotify($data));
            return response()->json(['OK']);
        } catch (Exception $th) {
            return response()->json(['BAD_REQUEST']);
        }
    }
}
