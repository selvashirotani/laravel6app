
@extends('layout.layout')

@section('top')

<div class="header">
</div>

<div class="main">

    <div class="card-body">
        <h1>メールアドレス変更　認証コード入力</h1>
        
        <p>（※ メールアドレスの変更はまだ完了していません）</p>
        <p>変更後のメールアドレスにお送りしましたメールに記載されている「認証コード」を入力してください。</p>
        <form method="POST" action="{{ route('member.auth_email') }}">
            @csrf

            <input type="hidden" name="member_id" value="{{Auth::user()->id}}">


            <div class="element_wrap">
                <label for="auth_code">認証コード</label>
                <input type="text" name="auth_code" value="{{ old('auth_code') }}" />
            </div>

            @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <button type="submit" class="btn btn-primary" name=btn_submit>
            認証コードを送信してメールアドレスの変更を完了する

            </button>


        </form>
    </div>
</div>

@endsection
