@extends('layouts.app')

@section('content')
    <h2>Персональний кабінет</h2>
    <div class="row col-lg-8 col-md-12">
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
        <div>
                                            <a class="dropdown-item" href="/profile">Профіль</a>                                            </a>
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                               onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
        
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
        </div>
		<a href="/profile/post">
			<button class="transparent-btn mb-3">
				Додати пост
			</button>
		</a>
        <div>
            @foreach ($posts as $post)
                <a href="profile/post/{{$post->id}}">                    
                    <div class="mb-3">
                        <h5>{{$post->name}}</h5>
                        <div class="img_preview">
                            <img src="{{$post->img}}" alt="">
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>	
@endsection	