<?php

use App\Mail\TokenMail;
use App\Token;
use Illuminate\Support\Facades\Mail;

class RequestTokenTest extends FeaturesTestCase
{

    public function test_a_guest_user_can_request_a_token()
    {
        Mail::fake();

        $user = $this->defaultUser(['email'=>'aarpwebmaster@gmail.com']);

        $this->visitRoute('token')
        	->type('aarpwebmaster@gmail.com','email')
        	->press('Solicitar token');

        $token = Token::where('user_id',$user->id)->first();

        $this->assertNotNull($token,'A token was not created');

        Mail::assertSent(TokenMail::class, function($mail) use($token,$user){
        	return $mail->hasTo($user) && $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Hemos enviado un enlace a tu correo para que puedas iniciar sesión.');
    }

    public function test_a_guest_user_can_request_a_token_without_an_email()
    {
        Mail::fake();        

        $this->visitRoute('token')
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

        $this->visitRoute('token')
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

        $this->visitRoute('token')
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
