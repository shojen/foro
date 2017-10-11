@extends('layouts.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<h1>{!! ($category->exists)?'Posts de '.$category->name:'Posts' !!}</h1>		
	</div>
	
</div>

<div class="row">
	<aside class="col-md-2">
		<h3>Filtros</h3>
		{!! Menu::make(trans('menu.filters'),'nav filters') !!}
		<h3>Categorías</h3>
		{!! Menu::make($categoryItems,'nav categories') !!}
		
	</aside>
	<section class="col-md-10">
			@each('posts.item',$posts,'post')
			
			
		

		{!! $posts->links() !!}
		
	</section>
	
</div>


@endsection