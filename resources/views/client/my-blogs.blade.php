@extends('layouts.app')

@section('content')	

	{{-- Повідомлення --}}
	@if(session('error'))
		<div class="div-error mb-3">
			{{ session('error') }}
		</div>
	@endif
	@if(session('success'))
		<div class="div-success mb-3">
			{{ session('success') }}
		</div>
	@endif

	<header>
		<h2>Мої блоги</h2>
		<a href="/profile/blog">
			<button class="transparent-btn mb-3">
				Додати блог
			</button>
		</a>
	</header>			
	@foreach ($blogs as $blog)
		<div class="blog-item mb-3">
			<header class="rel">
				<a href="/blog/{{$blog->id}}">
					<h3 class="me-5">{{ $blog->title }}</h3>
				</a>
				<!-- Кнопка налаштувань -->					
				<div class="options-btn">
					<div class="custom-dropdown-btn">
						<i class="fa-solid fa-ellipsis"></i>
					</div>
					<div class="custom-dropdown-menu">
						<a class="dropdown-item" href="/profile/blog/{{$blog->id}}">Редагувати</a>
						<a class="dropdown-item" href="/profile/blog/{{$blog->id}}/del">Видалити</a>
					</div>
				</div>
			</header>
			
			<a href="/blog/{{$blog->id}}">
				<div class="pb-2">
					{!! Str::limit(strip_tags($blog->content), 200) !!}

					@if (strlen($blog->content) > 200)
						<span>Читати більше</span>
					@endif
				</div>
				<div>
					<span>{{ $blog->created_at->format('d.m.Y H:i:s') }}</span>
					<b class="ms-1">{{ $blog->category? '#'.$blog->category->name:'' }}</b>
				</div>
			</a>	
		</div>
	@endforeach

@endsection
