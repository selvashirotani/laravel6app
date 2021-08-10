@extends('layout.layout')

@section('top')

<!-- /password/resetが反映されるファイルはこちら。 -->

<div class="header">
</div>

<div class="main">

    @if (session('status'))
        <p>パスワード再設定の案内メールを送信しました 。</p>
        <p>（ まだパスワード再設定は完了しておりません ）</p>
        <p>届きましたメールに記載されている </p>
        <p>『パスワード再設定URL』 をクリックし、</p>
        <p>パスワードの再設定を完了させてください。</p>
        <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>
    
    @else

    <p>パスワード再設定用の URL を記載したメールを送信します。 </p>
    <p>ご登録されたメールアドレスを入力してください。</p>



    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="element_wrap">
            <label for="email">メールアドレス</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>メールアドレスが間違っています。</strong>
                </span>
            @enderror
           
        </div>

        <button type="submit" class="btn btn-primary" name=btn_submit>
           送信する
        </button>

        <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>

    </form>

    @endif
</div>
@endsection
