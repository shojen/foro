<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $fillable=['comment','post_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function MarkAsAnswer()
    {
    	
    	$this->post->pending=false;
    	$this->post->answer_id=$this->id;    	

    	$this->post->save();        
    }

    public function getAnswerAttribute()
    {    	
    	return $this->id === $this->post->answer_id;
    }

    public function getSafeHtmlContentAttribute()
    {
        return Markdown::convertToHtml(e($this->comment));
    }
}
