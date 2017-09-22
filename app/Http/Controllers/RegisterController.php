<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function create()
    {
    	return view('register/create');
    }

    public function store(Request $request)
    {
    	
    	$v= Validator::make($request->all(),[
    		'email' 		=> 'required|email|unique:users,email',
    		'username' 		=> 'required|max:255',
    		'first_name' 	=> 'required|max:255',
    		'last_name' 	=> 'required|max:255'
    	]);

    	if($v->fails())
    	{
    		return back()->withInput()->withErrors($v);
    	}

    	$user = User::create($request->all());

    	Token::generateFor($user)->sendByEmail();

        return redirect()->route('register_confirmation');
    }

    public function confirm()
    {
        return view('register.confirm');
    }
}
