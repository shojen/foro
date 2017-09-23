<?php

namespace App;

use App\Mail\TokenMail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;

class Token extends Model
{
	protected $guarded=[];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function login()
    {
        auth()->login($this->user);

        $this->delete();
    }

    public static function findActive($token)
    {

        return static::where('token',$token)->where('created_at','>=',Carbon::parse('-30 minutes'))->first();
    }

    public function getRouteKeyName()
    {
        return 'token';
    }

    public function getUrlAttribute()
    {
        return route('login',$this->token);
    }

    public static function generateFor(User $user)
    {
    	/*return static::create([
    		'user_id'=>$user->id,
    		'token' => str_random(60)
    	]); */

    	$token = new static;

    	$token->token = str_random(60);

    	$token->user()->associate($user);

    	$token->save();

    	return $token;
    }

    public function sendByEmail()
    {
    	Mail::to($this->user)->send(new TokenMail($this));
    }
}
