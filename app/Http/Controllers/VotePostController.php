<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class VotePostController extends Controller
{	

    public function upvote(Post $post)
    {
    	$post->upvote($post);

    	return ['new_score'=>$post->score];
    }

    public function downvote(Post $post)
    {
    	$post->downvote($post);

    	return ['new_score'=>$post->score];
    }

    public function undovote(Post $post)
    {
    	$post->undovote($post);

    	return ['new_score'=>$post->score];
    }
}
