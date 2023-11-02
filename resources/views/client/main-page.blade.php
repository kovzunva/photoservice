@extends('layouts.app')

@section('content')
    <h2>Вас вітає головна сторінка!</h2> 
    <div class="container-photo">
        @foreach ($posts as $post)
            <a href="/post/{{$post->id}}">                    
                <div class="mb-3">
                    <h5>{{$post->name}}</h5>
                    <div class="img_preview">
                        <img src="{{$post->img}}" alt="">
                    </div>
                </div>  
            </a>
        @endforeach
    </div>
@endsection	