@extends('layout.layout')

@section('top')

<div class="header">
            
    @guest

        <div class = "right-column">
        @if (Route::has('form.send'))
            <a class="headerbutton" href="{{ url('/form') }}">新規会員登録</a>
        @endif

        @if (Route::has('login'))
            <a class="headerbutton" href="{{ route('login') }}">ログイン</a>
        @endif
        </div>

        
    @else
            <div class = "left-column">
                <p> {{ Auth::user()->name_sei }} {{ Auth::user()->name_mei }}様</p>
            </div>

            <div class = "right-column">
            <a class="headerbutton" href="{{ url('/item') }}">新規商品登録</a>
            <a class="headerbutton" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                ログアウト
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            </div>
    @endguest

</div class="header">

<div class="main laravelwork">
    <h1>laravel課題</h1>
</div>


<!-- 
パスワードがちゃんと設定できたときにおくられる。    
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif -->



@endsection
