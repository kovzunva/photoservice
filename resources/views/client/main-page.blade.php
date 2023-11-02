@extends('layouts.app')

@section('content')
    <h2>Вас вітає головна сторінка!</h2> 
    <div>
        @foreach ($posts as $post)
            <span class="ava">{{ $post->user->name[0] }}</span>
            <span>{{ $post->user->name }},</span>
            <span>{{ $post->created_at->format('d.m.Y H:i:s') }}</span>
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