
@extends('layout.layout')

@section('top')

<div class="header">
</div>

<div class="main">
    <div class="card-body">
        <h1>パスワード変更</h1>
        @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('member.change_pass') }}">
            @csrf

            <input type="hidden" name="email" value="{{Auth::user()->email}}">

            <div class="element_wrap">
                <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

            </div>

            <div class="element_wrap">
                <label for="password-confirm" >パスワード確認</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary" name=btn_submit>
                パスワード変更
            </button>

            <a class="back-btn" href="/member/detail?id={{Auth::user()->id}}">マイページに戻る</a>

        </form>
    </div>
</div>

@endsection
