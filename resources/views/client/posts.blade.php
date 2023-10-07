@extends('layouts.app')




@section('content')	

	<header class="mb-3">
		<h2>Блоги</h2>		
	</header>		

	@foreach ($posts as $post)
	<a href="/post/{{$post->id}}">
		<div class="post-item mb-3">
			<header>
				<h3 class="me-5">{{ $post->title }}</h3>
			</header>
			
			<div class="pb-2">
				{!! Str::limit(strip_tags($post->content), 200) !!}
				@if (strlen($post->content) > 200)
					<span>Читати більше</span>
				@endif
			</div>
			<div>
				<span class="ava">{{ $post->user->name[0] }}</span>
				<span>{{ $post->user->name }},</span>
				<span>{{ $post->created_at->format('d.m.Y H:i:s') }}</span>
				<b class="ms-1">{{ $post->category? '#'.$post->category->name:'' }}</b>
			</div>
		</div>
	</a>	
	@endforeach
	{{ $posts->count()==0 ? "Нема блогів за таким запитом":"" }}

	<div class="text-end">
		{!! $paginator !!}
	</div>

@endsection
	