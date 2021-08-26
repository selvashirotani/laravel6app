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
    <a class="back-btn" href="{{ url('/admin/members') }}">会員一覧</a>
    <a class="back-btn" href="{{ url('/admin/items/category') }}">商品カテゴリ一覧</a>
    <a class="back-btn" href="{{ url('/admin/products/all') }}">商品一覧</a>
    <a class="back-btn" href="{{ url('/admin/reviews/all') }}">商品レビュー一覧</a>
</div>

@endsection
