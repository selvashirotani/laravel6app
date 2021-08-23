<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')

<div class="header">
            
	<div class = "left-column">
	@if(!empty($input['id']))
		<p>会員編集</p>
	@else
		<p>会員登録</p>
	@endif
	</div>

	<div class = "right-column">
		<a class="headerbutton" href="{{  url('/admin/members') }}">一覧へ戻る</a>
	</div>


</div class="header">

<div class="main">

    <form method="post" action="{{ route('admin_member.send') }}" onsubmit="return checkNijyuSubmit();">
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
		@if(!empty($input['id']))
		<input type="submit" name="btn_submit" id="btnSubmit" value="編集完了">
		@else
		<input type="submit" name="btn_submit" id="btnSubmit" value="登録完了">
		@endif
	</form>
</div>
@endsection