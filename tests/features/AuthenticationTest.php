<?php

use App\Token;

class AuthenticationTest extends FeaturesTestCase
{
	public function test_an_user_can_login_with_a_token_url()
	{
		$user=$this->defaultUser();

		$token=Token::generateFor($user);

		$this->visitRoute('login',$token->token)
			->seeIsAuthenticated()
			->seeIsAuthenticatedAs($user);

		$this->dontSeeInDatabase('tokens',[
			'id'	=> $token->id,
		]);

		$this->seePageIs('/');
	}
}
