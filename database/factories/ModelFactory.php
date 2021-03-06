<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'username'  => $faker->unique()->username,
        'email' => $faker->unique()->safeEmail,        
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Category::class,function(Faker\Generator $faker){
    return [
        'name'=>$faker->unique()->sentence,
    ];
});

$factory->define(App\Post::class, function (Faker\Generator $faker) {
    

    return [
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'pending' => true,  
        'user_id' => function(){
            // En el caso de que no se asigne user_id a la prueba, se creará un usuario nuevo entrando en esta función, En caso contrario se tomará el usuario que se le asigne a la prueba, en el caso que estamos tratando, es el usuario por defecto que contenga como nombre Angel Rosso
            return factory(\App\User::class)->create()->id;
        }, 
        'category_id' => function(){

            return factory(\App\Category::class)->create()->id;
        }     
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    

    return [
        'comment' => $faker->paragraph,
        'post_id' => function(){
            return factory(\App\Post::class)->create()->id;
        },        
        'user_id' => function(){
            // En el caso de que no se asigne user_id a la prueba, se creará un usuario nuevo entrando en esta función, En caso contrario se tomará el usuario que se le asigne a la prueba, en el caso que estamos tratando, es el usuario por defecto que contenga como nombre Angel Rosso
            return factory(\App\User::class)->create()->id;
        },      
    ];
});