
@extends('layout.layout')

@section('top')

<div class="header">
</div>

<div class="main">

    <div class="card-body">
        <h1>メールアドレス変更</h1>
        @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('member.change_email') }}">
            @csrf

            <input type="hidden" name="member_id" value="{{Auth::user()->id}}">

            <div class="element_wrap">
                <label for="password">現在の</br>メールアドレス</label>
                    <p>{{Auth::user()->email}}</p>

            </div>

            <div class="element_wrap">
                <label for="email">変更後の</br>メールアドレス</label>
                <input type="email" name="email" value="{{ old('email') }}" />
            </div>

            <button type="submit" class="btn btn-primary" name=btn_submit>
                認証メール送信
            </button>

            <a class="back-btn" href="/member/detail?id={{Auth::user()->id}}">マイページに戻る</a>

        </form>
    </div>
</div>

@endsection
