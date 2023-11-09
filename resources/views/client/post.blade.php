@extends('layouts.app')

@section('content')
	<!-- {{-- Повідомлення --}}
	@if(session('error'))
		<div class="div-error mb-3">
			{{ session('error') }}
		</div>
	@endif
	@if(session('success'))
		<div class="div-success mb-3">
			{{ session('success') }}
		</div>
	@endif -->

	<section>
		<div class="my-card">
			<div class="row g-0">
				
				<div class="col-md-6">
					<div class="img_preview">
						<img src="{{asset($img)}}" alt="">
					</div>
				</div>
				
				
				<div class="col-md-6 my-disript flex-column">
					<div class="flex-grow-1">
							<h2 class="me-5">{{$post->name}}</h2>


						@if ($post->user_id === auth()->id())
							<div class="options-btn">
								<div class="custom-dropdown-btn">
									<i class="fa-solid fa-ellipsis"></i>
								</div>
								<div class="custom-dropdown-menu dropdown-menu">
									<a class="dropdown-item" href="/profile/post/{{$post->id}}">Редагувати</a>
									<a class="dropdown-item" href="/profile/post/{{$post->id}}/del">Видалити</a>
								</div>
							</div>
						@endif
						
						<div class="text-from-editor">
						{{ $post->about }}
						</div>
						
						<div class="d-flex justify-content-between align-items-center">

							<span>автор: {{ $post->user->name }}</span>
							<span>опубліковно: {{ $post->created_at->format('d.m.Y H:i:s') }}</span>
						</div>
					</div>


					{{-- Вподобайки та кількість коментів --}}

					<div class="flex-grow-0">

						<form method="POST" action="/comment/add" class="validate-form">
							@csrf
							<input type="hidden" name="post_id" value="{{ $post->id }}">

							<div class="form-group">
								<div class="d-flex justify-content-between align-items-center">
									<label for="comment"><h5>Ваша думка?</h5></label>
									<div>
									<div class="like-group">
										<input type="hidden" name="item_id" value="{{$post->id}}">
										<input type="hidden" name="item_type" value="post">
										<i class="
												@if (Auth::check() && $post->likes->where('user_id', Auth::user()->id)->count() > 0)
													fa-solid @else fa-regular
												@endif
													fa-heart like-btn"></i>
										<span class="count-span likes-count">{{$post->likes->count()}}</span>
									</div>
									</div>
								</div>
								<div class="error-text hide" id="error_content"></div>
								<textarea class="my-required" id="comment" name="content" rows="2"></textarea>
							</div>


							<div class="text-end">
								<button type="submit" class="btn my-btn">опублікувати</button>
							</div>
						</form>

					</div>	
				</div>
			</div>

			<section class="p-2">
		    <h4>Коментарі ({{$post->comments->count()}}):</h4> 
		{{ count($post->comments) > 0 ? '' : 'ніхто не висловив свою думку...' }}
		@foreach ($post->comments as $comment)
			<hr>

			<div class="comment-item mb-3" data-comment-id="{{ $comment->id }}">
				<header class="rel d-flex justify-content-between align-items-center ">
					<h5>{{ $comment->user->name }}</h5>
					
					<div>
					<p class="m-none">
						{{ $post->created_at->format('d.m.Y H:i:s')
					}}@if ($comment->updated_at != $comment->created_at), змінено
						@endif
					</p>

					@if ($comment->user_id === auth()->id())
						<div class="options-btn">
							<div class="custom-dropdown-btn">
								<i class="fa-solid fa-ellipsis-vertical"></i>
							</div>
							<div class="custom-dropdown-menu dropdown-menu">
								<a class="dropdown-item" href="/comment/{{$comment->id}}/del">Видалити</a>
							</div>
						</div>
					@endif
				
				</div>
				</header>

				<div class="comment-text my-px-3">
					<p>{{ $comment->content }}</p>
					
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





		</div>
	</section>



	<!-- <section>
		



		<h4>Коментарі:</h4>
 
		 Виведення коментарів 
		{{ count($post->comments) > 0 ? '' : 'Ще нема коментарів' }}
		@foreach ($post->comments as $comment)
			<hr>
			<div class="comment-item mb-3" data-comment-id="{{ $comment->id }}">
				<header class="rel">
					<h5 class="me-5">{{ $comment->user->name }}</h5>
					 Кнопка налаштувань
					@if ($comment->user_id === auth()->id())
						<div class="options-btn">
							<div class="custom-dropdown-btn">
								<i class="fa-solid fa-ellipsis"></i>
							</div>
							<div class="custom-dropdown-menu">
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
	</section>  -->

@endsection


