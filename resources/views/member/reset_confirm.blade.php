@extends('layout.layout')

@section('form')

<div class="main">

	<h1>会員情報変更確認画面</h1>
	

    <form method="post" action="{{ route('member.send') }}" onsubmit="return checkNijyuSubmit();">
	@csrf
    <input type="hidden" name="email" value="{{Auth::user()->email}}">
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
		
		<button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
		<input type="submit" name="btn_submit" id="btnSubmit" value="登録完了">
	</form>
</div>
@endsection