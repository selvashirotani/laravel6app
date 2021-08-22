@extends('admin.layout')

@section('top')
<div class="header">
</div>

<div class="main">

    <h1>管理画面</h1>


    <form method="POST" action="{{ route('admin.login') }}">
        @csrf

        <div class="element_wrap">
            <label for="login_id" >ログインID</label>
                <input id="login_id" type="text" name="login_id" value="{{ old('login_id') }}" required autocomplete="login_id" autofocus>

                @error('login_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>ログインIDもしくはパスワードが間違っています</strong>
                    </span>
                @enderror

                @if(isset($login_id))
                    <span class="invalid-feedback" role="alert">
                        <strong>ログインIDもしくはパスワードが間違っています</strong>
                    </span>
                @endif
        </div>

        <div class="element_wrap">
            <label for="password" >パスワード</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
        </div>

        <button type="submit" name="btn_submit">
            ログイン
        </button>

    </form>


</div>

@endsection
