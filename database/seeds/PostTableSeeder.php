<?php

use App\Category;
use App\Post;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$categories=Category::select('id')->get();
    	
    	foreach(range(1,100) as $i) {
        	factory(Post::class)->create([
        		'category_id' => $categories->random()->id,
                'pending' => rand(0,1),
                'created_at'=>Carbon::now()->subHours(rand(0,720))
        	]);
    		
    	}
    }
}
