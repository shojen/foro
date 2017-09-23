<?php

use App\Mail\TokenMail;
use App\Token;
use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;


class TokenMailTest extends FeaturesTestCase
{
    /**
    * @test
    */
    public function it_send_email_with_the_token()
    {
    	$user = new User([
    		'username' => 'shojen',
    		'email' => 'aarpwebmaster@gmail.com',
    		'first_name' => 'Angel',
    		'last_name' => 'Rosso'
    	]);

        $token = new Token([
        	'token' => 'my-token',
        	'user_id' => $user->id,
        ]);

        $this->open(new TokenMail($token))
        	->seeLink($token->url,$token->url);
    }

    public function open(Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

    	Mail::send($mailable);

        $message = $transport->messages()->first();

        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}
