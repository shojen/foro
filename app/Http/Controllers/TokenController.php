<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function create()
    {
    	return view('token.create');
    }

    public function store(Request $request)
    {
    	$this->validate($request,[
    		'email' => 'required|email|exists:users,email'
    	]);

    	$user = User::where('email',$request->get('email'))->first();

    	Token::generateFor($user)->sendByEmail();

    	alert('Hemos enviado un enlace a tu correo para que puedas iniciar sesión.');

    	return back();
    }

}
