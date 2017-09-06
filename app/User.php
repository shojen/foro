<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Post::class);
    }

    public function comment(Post $post,$message)
    {
        $comment= new Comment([
                'comment'   => $message,              
                'post_id'   => $post->id,
            ]);

        $this->comments()->save($comment);
    }

    public function owns(Model $model)
    {   
        return $this->id === $model->user_id;
    }
}
