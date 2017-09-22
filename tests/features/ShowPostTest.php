<?php

class ShowPostTest extends FeaturesTestCase
{
    
    public function test_a_user_can_see_the_post_details()
    {
    	// Having
    	$user = $this->defaultUser([
    			'first_name'	=> 'Angel Rosso',
    		]);

        $post = $this->createPost([
        		'title'	=> 'Este es el titulo del post',
        		'content'	=> 'Este es el contenido del post',
                'user_id'   => $user->id,
        	]);

        
        // When
        $this->visit($post->url)
        	->seeInElement('h1',$post->title)
        	->see($post->content)
        	->see('Angel Rosso');
    }

    public function test_old_urls_are_redirected()
    {
        //Having  
        $post = $this->createPost([
                'title' => 'Old title',
            ]);

        $url = $post->url;

        $post->update(['title'=>'New title']);

        // When
        $this->visit($url)
            ->seePageIs ($post->url);
    }
}
