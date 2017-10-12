@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-10">
            <h1>{{ $post->title }}</h1>
                
                    
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <p>
                    Publicado por <a href="#">{{ $post->user->first_name }}</a>
                    {{ $post->created_at->diffForHumans() }}
                    en <a href="{{ $post->category->url }}">{{ $post->category->name }}</a>.
                    @if ($post->pending)
                        <span class="label label-warning">Pendiente</span>
                    @else
                        <span class="label label-success">Completado</span>
                    @endif
                </p>
                
                {!! $post->safe_html_content !!}
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
        
      

                <h4>Comentarios:</h4>
                {!! Form::open(['route'=>['comments.store',$post], 'method'=>'POST']) !!}
                    {!! Field::textarea('comment',['rows'=>'3']) !!}
                    {!! Form::submit('Publicar comentario', ['class'=>'btn btn-default center-block']) !!}
                {!! Form::close() !!}
                <hr>
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
                    <hr>
                @endforeach     
            </div>
            @include('posts.sidebar')
        </div>

@endsection
