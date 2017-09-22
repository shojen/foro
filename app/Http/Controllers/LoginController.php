<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Token $token)
    {
    	auth()->login($token->user);

    	$token->delete();

    	return redirect('/');
    }
}
