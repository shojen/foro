<?php

use App\Mail\TokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;

class AuthenticationTest extends FeaturesTestCase
{

    public function test_a_guest_user_can_request_a_token()
    {
        Mail::fake();

        $user = $this->defaultUser(['email'=>'aarpwebmaster@gmail.com']);

        $this->visitRoute('login')
        	->type('aarpwebmaster@gmail.com','email')
        	->press('Solicitar token');

        $token = Token::where('user_id',$user->id)->first();

        $this->assertNotNull($token,'A token was not created');

        Mail::assertSentTo($user,TokenMail::class, function($mail) use($token){
        	return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Hemos enviado un enlace a tu correo para que puedas iniciar sesión.');
    }

    public function test_a_guest_user_can_request_a_token_without_an_email()
    {
        Mail::fake();        

        $this->visitRoute('login')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token,'A token was created');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'El campo correo electrónico es obligatorio'
        ]);
    }

    public function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
        Mail::fake();        

        $this->visitRoute('login')
            ->type('shojen','email')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token,'A token was created');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'correo electrónico no es un correo válido'
        ]);
    }

    public function test_a_guest_user_can_request_a_token_with_non_existent_email()
    {
        Mail::fake();        

        $this->visitRoute('login')
            ->type('shojen@shojen.com','email')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token,'A token was created');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors([
            'email' => 'correo electrónico es inválido'
        ]);
    }
}
