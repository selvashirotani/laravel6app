@extends('layout.layout')

@section('top')

<div class="main">

    <h1>ログイン</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="element_wrap">
            <label for="email" >メールアドレス</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>メールアドレスもしくはパスワードが間違っています</strong>
                    </span>
                @enderror
        </div>

        <div class="element_wrap">
            <label for="password" >パスワード</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>メールアドレスもしくはパスワードが間違っています</strong>
                    </span>
                @enderror
        </div>

        <!-- 覚えときますか？のん -->
        <!-- <div class="element_wrap">
            <div class="col-md-6 offset-md-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
        </div> -->

        <button type="submit" name="btn_submit">
            ログイン
        </button>

        <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>

        @if (Route::has('password.request'))
            <a class="btn btn-link" href="{{ route('password.request') }}">
                パスワードを忘れた方はこちら
            </a>
        @endif

</div>

@endsection
