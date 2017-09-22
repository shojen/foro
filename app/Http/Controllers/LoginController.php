<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login($token)
    {

    	$token=Token::findActive($token);

    	if(!$token)
    	{
    		alert('Este enlace ya expiró. Por favor solicita otro','danger');

    		return redirect()->route('token');
    	}
    	

    	$token->login();

    	return redirect('/');
    }
}
