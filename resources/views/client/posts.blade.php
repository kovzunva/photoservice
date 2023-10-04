@extends('layouts.app')



@section('aside')	

	<form action="/blogs" method="GET">

		<div class="mb-3">
			<label for="" class="form-label">Категорія</label>
			<div class="base-select">
				<div class="select-box">
					<span class="selected-option d-flex align-items-center">
						@if (!request()->has('category') || request()->input('category') == 'all')
							Всі категорії
						@elseif (request()->input('category') == '')
							Інше
						@else
							{{ $selectedCategory->name }}
						@endif
					<i class="fa-solid fa-angle-down ml-auto"></i></span>
					<ul class="options hide">
						<li data-value="all" class="filter-option">Всі категорії</li>
						<li data-value="" class="filter-option">Інше</li>
						@foreach ($categories as $category)
							<li data-value="{{ $category->id }}" class="filter-option">{{ $category->name }}</li>
						@endforeach
					</ul>
				</div>
				<input type="hidden" name="category" value="
					@if (!request()->has('category') || request()->input('category') == 'all')
						all
					@elseif (request()->input('category') == '')
						
					@else
						{{ $selectedCategory->id }}
					@endif
				">
			</div>     
		</div>
		
		<div class="mb-3">
			<label for="" class="form-label">Дата (від)</label>
			<input type="text" class="input-date" name="date_from" value="{{$selectedDateFrom? $selectedDateFrom:''}}"> 
		</div>
		<div class="mb-3">
			<label for="" class="form-label">Дата (до)</label>
			<input type="text" class="input-date" name="date_to" value="{{$selectedDateTo? $selectedDateTo:''}}"> 
		</div>

		<button type="submit" class="base-btn w-100">Фільтрувати</button>
	</form>

@endsection



@section('content')	

	<header class="mb-3">
		<h2>Блоги</h2>		
	</header>		

	@foreach ($blogs as $blog)
	<a href="/blog/{{$blog->id}}">
		<div class="blog-item mb-3">
			<header>
				<h3 class="me-5">{{ $blog->title }}</h3>
			</header>
			
			<div class="pb-2">
				{!! Str::limit(strip_tags($blog->content), 200) !!}
				@if (strlen($blog->content) > 200)
					<span>Читати більше</span>
				@endif
			</div>
			<div>
				<span class="ava">{{ $blog->user->name[0] }}</span>
				<span>{{ $blog->user->name }},</span>
				<span>{{ $blog->created_at->format('d.m.Y H:i:s') }}</span>
				<b class="ms-1">{{ $blog->category? '#'.$blog->category->name:'' }}</b>
			</div>
		</div>
	</a>	
	@endforeach
	{{ $blogs->count()==0 ? "Нема блогів за таким запитом":"" }}

	<div class="text-end">
		{!! $paginator !!}
	</div>

@endsection
	