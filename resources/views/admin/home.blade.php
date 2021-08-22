@extends('admin.layout')

@section('top')

<div class="header">
        
            <div class = "left-column">
                <p>管理画面メインメニュー</p>
            </div>

            <div class = "right-column">
            <p class="header-msg"> ようこそ{{$data}}さん　　　</p>
            <a class="headerbutton" href="{{ route('admin.form') }}">ログアウト</a>

            </div>

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
