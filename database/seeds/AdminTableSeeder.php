<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
        	'first_name' => 'Angel',
	        'last_name' => 'Rosso',
	        'username'  => 'shojen',
	        'email' => 'aarpwebmaster@gmail.com',
	        'role'	=> 'admin'
        ]);
    }
}
