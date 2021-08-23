
@extends('layout.layout')

@section('top')

<div class="header">
</div>

<div class="main">
    <div class="card-body">
        <h1>会員情報変更</h1>
        @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('member.change') }}">
            @csrf

            <input type="hidden" name="" value="">

            <input type="hidden" name="email" value="{{Auth::user()->email}}">

            <div class="element_wrap">
                <label for="name">氏名</label>              
                <p>姓</p>
                <input type="text" name="name_sei" value="@if(old('name_sei')) {{old('name_sei')}} @else {{Auth::user()->name_sei}} @endif" />
                <p>名</p>
                <input type="text" name="name_mei" value="@if(old('name_mei')) {{old('name_mei')}} @else {{Auth::user()->name_mei}} @endif" />
            </div>

            <div class="element_wrap">
                <label for="nickname">ニックネーム</label>
                <input type="text" name="nickname" value="@if(old('nickname')) {{old('nickname')}} @else {{Auth::user()->nickname}} @endif" />  
            </div>

            <div class="element_wrap">
                <label for="name">性別</label>
                @if(old('gender'))
                <label for="gender_male"><input id="gender_male" type="radio" name="gender" value="1"  @if(old('gender')=="1") checked @endif />男性</label>
                <label for="gender_female"><input id="gender_female" type="radio" name="gender" value="2" @if(old('gender')=="2") checked @endif/>女性</label>
                @else
                <label for="gender_male"><input id="gender_male" type="radio" name="gender" value="1"  @if(Auth::user()->gender==1) checked @endif />男性</label>
                <label for="gender_female"><input id="gender_female" type="radio" name="gender" value="2" @if(Auth::user()->gender==2) checked @endif/>女性</label>
                @endif
            </div>

            <button type="submit" class="btn btn-primary" name=btn_submit>
                確認画面へ
            </button>

            <a class="back-btn" href="/member/detail?id={{Auth::user()->id}}">マイページに戻る</a>

        </form>
    </div>
</div>

@endsection
