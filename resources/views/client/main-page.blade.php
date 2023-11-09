@extends('layouts.app')

@section('content')
    <div class="container-photo">
        @foreach ($posts as $post)
        <div class="my-a">
            <a class="" href="/post/{{$post->id}}">                    
                <div class="mb-3">
                    <div class="img_preview">
                        <img src="{{$post->img}}" alt="">
                    </div>
                    <h5 class="img-name">{{$post->name}}</h5>
                </div>  
            </a>
            </div> 
        @endforeach
    </div>
@endsection	