<!DOCTYPE html>

<!-- 
1. /formにアクセスするとフォームが表示
2. 送信すると/form/confirmにリダイレクトして確認画面が表示
3. 確認画面から戻るボタンで入力内容が修正出来る
4. 確認画面から送信ボタンで完了画面（/form/thanks)を表示
 -->

@extends('layout.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
        

        <div class="main">
        <!-- 2021080223:35 エラー文の表示 -->
        @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- ここまで -->
            <h1>会員情報登録</h1>  
                <form method="post" action="{{ route('form.post') }}">
                <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                    @csrf
                    <!-- これだけでcsrf対策 -->

                    <!-- 各要素はバリデーション後に戻ってくることがあるため、old()関数を使います -->
                    <div class="element_wrap">
                        <label for="name">氏名</label>              
                        <p>姓</p>
                        <input type="text" name="name_sei" value="{{ old('name_sei') }}" />
                        <p>名</p>
                        <input type="text" name="name_mei" value="{{ old('name_mei') }}" />
                    </div>

                    <div class="element_wrap">
                        <label for="nickname">ニックネーム</label>
                        <input type="text" name="nickname" value="{{ old('nickname') }}" />  
                    </div>

                    <!-- <div class="element_wrap">
                        <label for="name">性別</label>
                        <label for="gender_male"><input id="gender_male" type="radio" name="gender" value="1"  @if(old('gender')=="1") checked @endif />男性</label>
                        <label for="gender_female"><input id="gender_female" type="radio" name="gender" value="2" @if(old('gender')=="2") checked @endif/>女性</label> -->
                        <!--性別入ってへんと言われるエラー 参照 https://webstock-blog.com/laravel-radio-initial-old/ -->
                        <!--バリデーションチェック方法 参照 https://qiita.com/shima0218/items/1320c82a060434330d71 -->
                        <!-- 全角スペースが入ってた。 -->
                    <!-- </div> -->

                    <!-- 2021080322:39 念のため性別2つ作成 -->
                    <div class="element_wrap">
                        <label for="name">性別</label>
                        @foreach (config('master') as $index => $value)
                        <label for="{{$value}}"><input id="{{$value}}" type="radio" name="gender" value="{{$index}}"  @if(old('master')=="{{$index}}") checked @endif />{{$value}}</label>
                        @endforeach
                    </div>

                    <div class="element_wrap">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" value="{{ old('password') }}" /> 
                    </div>

                    <div class="element_wrap">
                        <label for="password_confirmation">パスワード確認</label>  
                        <input type="password" name="password_confirmation" />
                        
                    </div>

                    <div class="element_wrap">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email') }}" />
                    </div>

                    <input type="submit" name="btn_confirm" value="確認画面へ" />
                    <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>
                </form>
        </div>
@endsection