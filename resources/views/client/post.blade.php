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

	<section>					
		<header class="rel">	

			<h2 class="me-5">{{$post->name}}</h2>	
			<div class="img_preview">
				<img src="{{asset($img)}}" alt="">
			</div>
			<div class="mb-2">
				<span>
					<span class="ava">{{ $post->user->name[0] }}</span>
					{{ $post->user->name }},
				</span>
				<span>{{ $post->created_at->format('d.m.Y H:i:s') }}</span>
			</div>

			@if ($post->user_id === auth()->id())
				<div class="options-btn">
					<div class="custom-dropdown-btn">
						<i class="fa-solid fa-ellipsis"></i>
					</div>
					<div class="custom-dropdown-menu">
						<a class="dropdown-item" href="/profile/post/{{$post->id}}">Редагувати</a>
						<a class="dropdown-item" href="/profile/post/{{$post->id}}/del">Видалити</a>
					</div>
				</div>
			@endif	

		</header>	 
		<div class="text-from-editor">
			{{ $post->about }}
		</div>
	</section>

	<section>
		{{-- Вподобайки та кількість коментів --}}
		<div class="text-end">		
			<div class="like-group">
				
				<span class="count-span">{{$post->comments->count()}}</span>
				<i class="
				@if (Auth::check() && $post->comments->where('user_id', Auth::user()->id)->count() > 0)
					fa-solid @else fa-regular
				@endif	
				fa-comment me-2"></i>

				{{-- <input type="hidden" name="item_id" value="{{$post->id}}">
				<input type="hidden" name="item_type" value="post">
				<span class="count-span likes-count">{{$post->likes->count()}}</span>
				<i class="
				@if (Auth::check() && $post->likes->where('user_id', Auth::user()->id)->where('item_type', 'post')->count() > 0)
					fa-solid @else fa-regular
				@endif						
					fa-heart like-btn"></i> --}}
			</div>
		</div>

		<form method="POST" action="/comment/add" class="validate-form">
			@csrf
			<input type="hidden" name="post_id" value="{{ $post->id }}">

			<div class="form-group">
				<label for="comment"><h4>Ваш коментар:</h4></label>
				<div class="error-text hide" id="error_content">Заповніть поле</div>
				<textarea class="required" id="comment" name="content" rows="4"></textarea>
			</div>
			
			<div class="text-end mt-2">							
				<button type="submit" class="btn base-btn">Опублікувати коментар</button>
			</div>
		</form>

		<h4>Коментарі:</h4>

		<!-- Виведення коментарів -->
		{{ count($post->comments) > 0 ? '' : 'Ще нема коментарів' }}
		@foreach ($post->comments as $comment)
			<hr>
			<div class="comment-item mb-3" data-comment-id="{{ $comment->id }}">
				<header class="rel">
					<h5 class="me-5">{{ $comment->user->name }}</h5>
					<!-- Кнопка налаштувань -->	
					@if ($comment->user_id === auth()->id())						
						<div class="options-btn">
							<div class="custom-dropdown-btn">
								<i class="fa-solid fa-ellipsis"></i>
							</div>
							<div class="custom-dropdown-menu">
								<a class="dropdown-item edit-comment-btn" data-comment-id="{{ $comment->id }}">Редагувати</a>
								<a class="dropdown-item" href="/comment/{{$comment->id}}/del">Видалити</a>
							</div>
						</div>
					@endif	
				</header>
				<div class="comment-text">
					<p>{{ $comment->content }}</p>
					<p class="m-none">
						{{ $post->created_at->format('d.m.Y H:i:s') 
					}}@if ($comment->updated_at != $comment->created_at), змінено
						@endif
					</p>
				</div>

				{{-- редагування коментаря --}}
				@if ($comment->user_id === auth()->id())	
					<form class="edit-comment-form" action="/comment/{{$comment->id}}/edit" method="POST" style="display: none;">
						@csrf
						<textarea class="" name="edit_content">{{ $comment->content }}</textarea>
						<div class="text-end mt-2">
							<button type="submit" class="base-btn">Зберегти</button>
						</div>
					</form>
				@endif

			</div>
		@endforeach
	</section>
	
@endsection


	