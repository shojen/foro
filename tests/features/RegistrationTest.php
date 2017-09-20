<?php

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Support\Facades\Mail;


class RegistrationTest extends FeaturesTestCase
{

    public function test_an_user_can_create_an_account()
    {

    	Mail::fake();

        $this->visitRoute('register')
        	->type('aarpwebmaster@gmail.com','email')
        	->type('shojen','username')
        	->type('Angel','first_name')
        	->type('Rosso','last_name')
        	->press('Regístrate');

        $this->seeInDatabase('users',[
        	'email' => 'aarpwebmaster@gmail.com',
        	'username' => 'shojen',
        	'first_name' => 'Angel',
        	'last_name' => 'Rosso'
        ]);

        $user = User::first();

        $this->seeInDatabase('tokens',[
        	'user_id' => $user->id
        ]);

        $token=Token::where('user_id',$user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSentTo($user,TokenMail::class,function($mail) use($token){
        	return $mail->token->id === $token->id;

        });

        $this->seeRouteIs('register_confirmation')
            ->see('Gracias por registrarte.')
            ->see('Hemos enviado un enlace a tu correo para que puedas iniciar sesión.');
    }
}
