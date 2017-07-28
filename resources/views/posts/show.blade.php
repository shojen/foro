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
</div>
@endsection
