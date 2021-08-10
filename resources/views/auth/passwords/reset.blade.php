
@extends('layout.layout')

@section('top')

<div class="header">
</div>

<div class="main">
    <div class="card-body">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <input id="email" type="hidden" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

            <div class="element_wrap">
                <label for="password">パスワード</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
            </div>

            <div class="element_wrap">
                <label for="password-confirm" >パスワード確認</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <button type="submit" class="btn btn-primary" name=btn_submit>
                パスワードリセット
            </button>

            <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>

        </form>
    </div>
</div>

@endsection
