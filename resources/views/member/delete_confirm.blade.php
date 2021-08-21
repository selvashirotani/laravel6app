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

    <p>退会します、よろしいですか？</p>
    <a class="back-btn" href="/member/detail?id={{Auth::user()->id}}">マイページに戻る</a>

    <a class="back-btn" href="{{ route('member.destroy') }}"
            onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();">
            退会する
        </a>
       
        <form id="delete-form" action="{{ route('member.destroy',['$id'])}}" method="POST" class="d-none">
        <input type="hidden" value="{{$id}}" name="user_id">
                @csrf
        </form>

</div>

@endsection