@extends('layout.layout')

@section('top')

<div class="header">
            
    <div class = "left-column">
            <p> マイページ</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{ url('/') }}">トップに戻る</a>
        <a class="headerbutton" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            ログアウト
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
        </form>
    </div>

</div>

<div class="main">

    <div class="element_wrap">
        <label>氏名</label>
        <p>{{ Auth::user()->name_sei }}　{{ Auth::user()->name_mei}}</p>
    </div>

    <div class="element_wrap">
        <label>ニックネーム</label>
        <p>{{Auth::user()->nickname}}</p>
    </div>

    <div class="element_wrap">
        <label>性別</label>
        @if(Auth::user()->gender === "1")
        <p>男性</p>
        @else
        <p>女性</p>
        @endif
    </div>

    <div class="element_wrap">
        <label>パスワード</label>
        <p>セキュリティのため非表示</p>
    </div>

    <div class="element_wrap">
        <label>メールアドレス</label>
        <p>{{ Auth::user()->email}}</p>
    </div>

    <a class="back-btn" href="/member/detail/delete?id={{ Auth::user()->id}}">退会</a>


</div>

@endsection