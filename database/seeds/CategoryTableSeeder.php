<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
        	'name' => 'Laravel'
        ]);
        Category::create([
        	'name' => 'PHP'
        ]);
        Category::create([
        	'name' => 'Vue.js'
        ]);
        Category::create([
        	'name' => 'JavaScript'
        ]);
        Category::create([
        	'name' => 'css'
        ]);
        Category::create([
        	'name' => 'Sass'
        ]);
        Category::create([
        	'name' => 'Git'
        ]);
        Category::create([
        	'name' => 'Otras Tecnologías'
        ]);
    }
}
