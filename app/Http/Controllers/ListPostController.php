<?php

namespace App\Http\Controllers;

use App\{Post,Category};
use Illuminate\Http\Request;

class ListPostController extends Controller
{
	public function __invoke(Category $category=null,Request $request)
	{
        $routeName = $request->route()->getName();

        list($orderColumn,$orderDirection)=$this->getListOrder($request->get('orden'));

        $filters=[
            'Posts'=>['full_url'=>route('posts.index')],
            'Posts Pendientes'=>['full_url'=>route('posts.pending')],
            'Posts Completados'=>['full_url'=>route('posts.completed')]
        ]; 

		$posts=Post::scopes($this->getListScopes($category,$routeName))
                    ->orderBy($orderColumn,$orderDirection)                    
                    ->paginate();

        $posts->appends(request()->intersect(['orden']));

        $categoryItems=$this->getCategoryItems($routeName);
		
		return view('posts.index')->with(compact('posts','categoryItems','category','filters'));
	}


    protected function getCategoryItems(string $routeName)
    {
        return Category::orderBy('name')->get()->map(function($category) use($routeName){
           return [ 
                    'title' => $category->name,
                    'full_url' => route($routeName,$category),
                ];

        })->toArray();
    }

    protected function getListScopes(Category $category,string $routeName)
    {
        $scopes=[];

        if($category->exists)
        {
            $scopes['category']=[$category];
        }        

        if($routeName=='posts.pending')
        {
            $scopes[] = 'pending';
        }
        elseif ($routeName=='posts.completed') {
            $scopes[] = 'completed';
        }

        return $scopes;
    }

    protected function getListOrder($order)
    {
        if($order=='recientes')
        {
            return ['created_at','desc'];
        }

        if($order=='antiguos')
        {
            return ['created_at','asc'];
        }

        return ['created_at','desc'];
    }
}