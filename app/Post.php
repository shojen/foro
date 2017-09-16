<?php

namespace App;

use GrahamCampbell\Markdown\Facades\Markdown;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    
    protected $fillable=['title','content'];

    protected $casts=[
        'pending' => 'boolean'
    ];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscribers()
    {
        return $this->belongsToMany(User::class,'subscriptions');
    }

    public function latestComments()
    {
        return $this->comments()->orderBy('created_at','DESC');
    }

    public function setTitleAttribute($value)
    {
    	$this->attributes['title']=$value;
    	$this->attributes['slug']=str_slug($value);
    }

    public function getUrlAttribute()
    {        dd($this);
        return route('posts.show',[$this->attributes['id'],$this->attributes['slug']]);
    }

    public function getSafeHtmlContentAttribute()
    {
        return Markdown::convertToHtml(e($this->content));
    }
}
