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
			{!! Form::open(['method'=>'get','class'=>'form form-inline']) !!}
				{!! Form::select('orden', trans('options.posts-order'), request('orden'), ['class'=>'form-control']) !!}
				{!! Form::submit('Ordenar', ['class'=>'btn btn-default']) !!}
			{!! Form::close() !!}

			@each('posts.item',$posts,'post')
			
		{!! $posts->render() !!}
		
	</section>
	
</div>


@endsection