<?php
use App\{Category,Post};
use \Carbon\Carbon;
class PostsListTest extends FeaturesTestCase
{

    public function test_a_user_can_see_the_posts_list_and_go_to_the_details()
    {
        $post = $this->createPost([
        		'title' => '¿Debo usar Laravel 5.3 o 5.1 LTS?'
        	]);

        $this->visit('/')
        	->seeInElement('h1','Posts')
        	->see($post->title)
        	->click($post->title)
        	->seePageIs($post->url);
    }

    public function test_a_user_can_see_posts_filtered_by_status()
    {
        $pendingPost=factory(Post::class)->create([
            'pending'=>true,
            'title' => 'Post pendiente'
        ]);
        $completedPost=factory(Post::class)->create([
            'pending'=>false,
            'title' => 'Post completado'
        ]);

        $this->visitRoute('posts.pending')
            ->see($pendingPost->title)
            ->dontSee($completedPost->title);

            $this->visitRoute('posts.completed')
            ->see($completedPost->title)
            ->dontSee($pendingPost->title);
    }

    public function test_a_user_can_see_posts_filtered_by_category()
    {

        //Have
        $laravel=factory(Category::class)->create([
            'name' => 'Laravel'
        ]);
        $vue=factory(Category::class)->create([
            'name' => 'Vue.js'
        ]);

        $laravelPost=factory(Post::class)->create([
            'category_id'=> $laravel->id,
            'title'=>'Posts de Laravel'
        ]);

        $vuePost=factory(Post::class)->create([
            'category_id'=> $vue->id,
            'title'=>'Posts de Vue'
        ]);

        
        $this->visit('/')
            ->see($laravelPost->title)
            ->see($vuePost->title)
            ->within('.categories',function(){
                $this->click('Laravel');
            })
            ->seeInElement('h1','Posts de Laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);
    }

    public function test_the_posts_are_paginated()
    {
    	// Having
    	$first=$this->createPost([
    		'title' => 'Post más antiguo',
    		'created_at'=> Carbon::now()->subDays(2)
    		]);    	
    	factory(\App\Post::class)->times(15)->create([
    			'created_at' => Carbon::now()->subDays(1)
    		]);
    	$last=$this->createPost(['title' => 'Post más reciente']);
    	
    	// When
    	$this->visit('/')
    		->see($last->title)
    		->dontSee($first->title)
    		->click('2')
    		->see($first->title)
    		->dontSee($last->title);

    	//dd($posts->toArray());
    }
}
