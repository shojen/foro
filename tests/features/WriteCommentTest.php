<?php

class WriteCommentTest extends FeaturesTestCase
{    
    public function test_a_user_write_a_comment()
    {
        $post = $this->createPost();
        $user = $this->defaultUser();
        //actuando como un usuario
        $this->actingAs($user)
        	->visit($post->url)
        	->type('Un comentario', 'comment')
        	->press('Publicar comentario');

        $this->seeInDatabase('comments',[
        		'comment' 	=> 'Un comentario',
        		'user_id'	=> $user->id,
        		'post_id'	=> $post->id,
        	]);

        $this->seePageIs($post->url);
    }

    public function test_pass_validation_when_a_user_write_a_comment()
    {
        $post = $this->createPost();
        $user = $this->defaultUser();
        $text= str_random(1001);

        $this->actingAs($user)
            ->visit($post->url)
            ->press('Publicar comentario')
            ->seeErrors([
                    'comment' => 'El campo comentario es obligatorio'
                ]);
        $this->actingAs($user)
            ->visit($post->url)
            ->type($text,'comment')
            ->press('Publicar comentario')
            ->seeErrors([
                    'comment' => 'comentario no debe ser mayor que 1000 caracteres.'
                ]);


    }
}
