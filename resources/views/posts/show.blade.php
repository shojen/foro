@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h1>{{ $post->title }}</h1></div>
                <div class="panel-body">
                    {!! $post->content !!}
                    <p>Escrito por:</p>
                    <p>{{ $post->user->name }}</p>
                </div>
            </div>
        </div>
    </div>
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
                    {{ $comment->comment }}
                    <p class="text-right">Autor: {{ $post->user->name }}</p>
                    {!! Form::open(['route'=>['comments.accept',$comment],'method'=>'POST']) !!}
                        <button type="submit">Aceptar respuesta</button>
                    {!! Form::close() !!}

                </article>
            @endforeach            
        
    </div>
</div>
@endsection
