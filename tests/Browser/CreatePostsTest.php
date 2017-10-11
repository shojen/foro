<?php

namespace Tests\Browser;

use App\Category;
use App\Post;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreatePostsTest extends DuskTestCase
{
    use DatabaseMigrations;

    protected $title='Esta es una pregunta';
    protected $content='Este es el contenido en el campo content';

    public function test_a_user_create_a_post()
    {

        $user = $this->defaultUser();
        $category=factory(Category::class)->create();
        //having ( lo que tenemos que es un usuario conectado, un titulo y un contenido)
        $this->browse(function($browser) use($user,$category){

            $browser->loginAs($user)
                    ->visitRoute('posts.create')
                    ->type('title',$this->title)//en browser dusk los valores de tipear está invertido, es decir, primero se pone el campo donde se escribirá y segundo el valor que se le asigna al input
                    ->type('content',$this->content)
                    ->select('category_id',$category->id)
                    ->press('Publicar')
                    ->assertPathIs('/posts/1-esta-es-una-pregunta');//esto es como seePageIs...


        });

        //then (entonces el resultado de lo que ha hecho sería...)
        //en vez de seeInDatabase se pone assertDatabaseHas
        $this->assertDatabaseHas('posts',[
                'title'     => $this->title,
                'content'   => $this->content,
                'user_id'   => $user->id,
                'pending'   => true
            ]);
        //El usuario es redirigido al detalle del post despues de crearlo
        //$this->see($title);
        
        $post = Post::first();
        
        //The author is subscrited automatically to the post
        $this->assertDatabaseHas('subscriptions',[
            'user_id'=>$user->id,
            'post_id'=>$post->id
            ]);
        
    }

    public function test_creating_a_post_requires_authentication()
    {
        $this->browse(function($browser){
            $browser->visitRoute('posts.create')
                ->assertRouteIs('token');
        });
        
    }

    public function test_create_post_form_validation()
    {

        $user = $this->defaultUser();
        $this->browse(function($browser) use($user){
            $browser->loginAs($user)
                ->visitRoute('posts.create')
                ->press('Publicar')
                ->assertRouteIs('posts.create')
                ->assertSeeErrors([
                    'title' => 'El campo título es obligatorio',
                    'content' => 'El campo contenido es obligatorio'
                ]);
        });

        
    }
}
