@extends('layouts.app')



@section('aside')	

@endsection



@section('content')	

	<header class="mb-3">
		<h2>Користувачі</h2>		
	</header>		

	@foreach ($users as $user)
	<a href="/profile/{{$user->id}}">
	</a>	
	@endforeach

	<div class="text-end">
		{!! $paginator !!}
	</div>

@endsection
	