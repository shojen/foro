<?php 

use App\Category;
use App\Post;

/**
* 
*/
class CreatePostsTest extends FeaturesTestCase
{
	public function test_a_user_create_a_post()
	{
		//having ( lo que tenemos que es un usuario conectado, un titulo y un contenido)
		$title='Esta es una pregunta en el campo titulo';
		$content='Este es el contenido en el campo content';

		$this->actingAs($user = $this->defaultUser());

		$category=factory(Category::class)->create();

		//when (cuando el usuario visite a la página que es lo que hace)
		$this->visit(route('posts.create'))
			->type($title,'title')
			->type($content,'content')
			->select($category->id,'category_id')
			->press('Publicar');


		//then (entonces el resultado de lo que ha hecho sería...)
		$this->seeInDatabase('posts',[
				'title'		=> $title,
				'content' 	=> $content,
				'user_id'	=> $user->id,
				'pending'	=> true,
				'category_id'=>$category->id,
			]);
		//El usuario es redirigido al detalle del post despues de crearlo
		//$this->see($title);
		
		$post = Post::first();
		
		//The author is subscrited automatically to the post
		$this->seeInDatabase('subscriptions',[
        	'user_id'=>auth()->id(),
        	'post_id'=>$post->id
        	]);
		$this->seePageIs($post->url);
	}

	public function test_creating_a_post_requires_authentication()
	{
		$this->visit(route('posts.create'))
			->seePageIs(route('token'));
	}

	public function test_create_post_form_validation()
	{
		$this->actingAs($this->defaultUser());

		$this->visit(route('posts.create'))
			->press('Publicar');

		$this->seePageIs(route('posts.create'))
			->seeErrors([
					'title'=>'El campo título es obligatorio',
					'content'=>'El campo contenido es obligatorio'
				]);
			//Lo de abajo se puede simplificar con la característica nueva agregada en FeaturesTestCase.php seeErrors
			//->seeInElement('#field_title .help-block','El campo título es obligatorio')
			//->seeInElement('#field_content .help-block','El campo contenido es obligatorio');
	}
	
}