<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable =['name','slug'];

    public function getRouteKeyName()
    {
        return 'slug';
    }
	
    public function posts()
    {
    	return $this->hasMany(Post::class);
    }

    public function setNameAttribute($value)
    {
    	$this->attributes['name']=$value;
    	$this->attributes['slug']=str_slug($value);
    }
}
