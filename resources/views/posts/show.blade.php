@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{ $post->title }}</h1></div>
                <div class="panel-body">
                    {!! $post->safe_html_content !!}
                    <p>Escrito por:</p>
                    <p>{{ $post->user->first_name }}</p>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->check())
        @if(!auth()->user()->isSubscribedTo($post))
            {!! Form::open(['route'=>['posts.subscribe',$post],'method'=>'POST']) !!}
            {!! Form::submit('Suscribirse al post') !!}
            {!! Form::close() !!}        
        @else
            {!! Form::open(['route'=>['posts.unsubscribe',$post],'method'=>'DELETE']) !!}
            {!! Form::submit('Desuscribirse del post') !!}
            {!! Form::close() !!}
        @endif
    @endif
    
    <div class="row">
        <h4>Comentarios:</h4>
        {!! Form::open(['route'=>['comments.store',$post], 'method'=>'POST']) !!}
            {!! Field::textarea('comment') !!}
            {!! Field::submit('Publicar comentario') !!}
        {!! Form::close() !!}
    </div>
    <div class="row">
        
            @foreach($post->latestComments as $comment)
                <article class="{{ $comment->answer ? 'answer' : '' }}">
                    
                    {!! $comment->safe_html_content !!}
                    <p class="text-right">Autor: {{ $post->user->first_name }}</p>
                    @if(Gate::allows('accept', $comment) && !$comment->answer)
                        {!! Form::open(['route'=>['comments.accept',$comment],'method'=>'POST']) !!}
                            <button type="submit">Aceptar respuesta</button>
                        {!! Form::close() !!}
                    @endif

                </article>
            @endforeach            
        
    </div>
</div>
@endsection
