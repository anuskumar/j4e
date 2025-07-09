<?php

namespace App\Http\Controllers;

use App\Mail\RequestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{

    public function requestemail()
    {
        $userEmail = 'sheebarobert18@gmail.com';
        Mail::to($userEmail)->send(new RequestMail());
    }
}
