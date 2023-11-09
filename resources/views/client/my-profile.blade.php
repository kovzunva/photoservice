@extends('layouts.app')

@section('content')
    <h2 class="my-h">Персональний кабінет</h2>
   
   
    <!-- <div class="row col-lg-8 col-md-12">
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
        
		

    </div>	 -->


    <div class="container-photo">
        <a href="/profile/post">
        <div class="my-a">
			<button class="btn my-btn-add">
				<h1>+</h1>
			</button>
        </div>
		</a>
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