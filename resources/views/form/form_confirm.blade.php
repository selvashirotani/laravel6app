<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('layout.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')

<div class="main">

	<h1>会員情報確認画面</h1>

    <form method="post" action="{{ route('form.send') }}" onsubmit="return checkNijyuSubmit();">
	@csrf
		<div class="element_wrap">
			<label>氏名</label>
			<p>{{ $input["name_sei"] }}　{{ $input["name_mei"] }}</p>
		</div>

        <div class="element_wrap">
			<label>ニックネーム</label>
			<p>{{ $input["nickname"] }}</p>
		</div>

		<div class="element_wrap">
			<label>性別</label>
            @if($input["gender"] === "1")
			<p>男性</p>
            @else
            <p>女性</p>
            @endif
		</div>

		<div class="element_wrap">
			<label>パスワード</label>
			<p>セキュリティのため非表示</p>
		</div>

		<div class="element_wrap">
			<label>メールアドレス</label>
			<p>{{ $input["email"] }}</p>
		</div>
		
		<button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
		<input type="submit" name="btn_submit" id="btnSubmit" value="登録完了">
	</form>
</div>
@endsection