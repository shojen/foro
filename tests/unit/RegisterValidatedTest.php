<?php

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterValidatedTest extends TestCase
{
	use DatabaseTransactions;
	
    public function test_the_inputs_cant_leave_empty()
    {
        $this->visitRoute('register')
        	->press('Regístrate');

        $this->seeRouteIs('register')
   			->see('El campo correo electrónico es obligatorio')
   			->see('El campo usuario es obligatorio')
   			->see('El campo nombre es obligatorio')
   			->see('El campo apellido es obligatorio');
   			
    }

    public function test_the_input_email_is_type_email_and_unique()
    {

    	$this->visitRoute('register')
    		->type('ss','email')
    		->type('shojen','username')
    		->type('Angel','first_name')
    		->type('Rosso','last_name')
    		->press('Regístrate');

    	$this->see('correo electrónico no es un correo válido');

    	$user = User::create([
    		'email'		=> 'aarpwebmaster@gmail.com',
    		'username' => 'shojen',
    		'first_name' => 'Angel',
    		'last_name'	=> 'Rosso'
    	]);

    	$this->type('aarpwebmaster@gmail.com','email')
    		->press('Regístrate');

    	$this->see('correo electrónico ya ha sido registrado');

    }
}
