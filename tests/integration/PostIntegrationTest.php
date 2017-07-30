<?php

use App\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PostIntegrationTest extends TestCase
{
	use DatabaseTransactions; //Con DatabaseTransactions, nos aseguramos de no ensuciar la base de datos, ya que después de usar la clase, hace un reject a la base de datos.

    public function test_a_slug_is_generated_and_saved_to_the_database()
    {
    	$user=$this->defaultUser();


    	$post = factory(Post::class)->make(['title' => 'Como instalar Laravel']);        

        $user->posts()->save($post);

        /*$this->seeInDatabase('post',[
        	'slug'=>'como-instalar-laravel'
        	]);*/
        	$this->assertSame(
        		'como-instalar-laravel',
        		$post->fresh()->slug //con esto nos aseguramos de que busca en la base de datos el último slug guardado..es como hacer un Post::first()
        		);
    }
}
