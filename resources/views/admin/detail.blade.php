<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')

<div class="header">
            
	<div class = "left-column">
	
		<p>会員詳細</p>

	</div>

	<div class = "right-column">
		<a class="headerbutton" href="{{  url('/admin/members') }}">一覧へ戻る</a>
	</div>


</div class="header">

<div class="main">
@if(!empty($members))
        @foreach ($members as $member)

        <div class="element_wrap">
			<label>ID</label>
			<p>{{ $member->id}}</p>
		</div>

		<div class="element_wrap">
			<label>氏名</label>
			<p>{{ $member->name_sei}}　{{ $member->name_mei}}</p>
		</div>

        <div class="element_wrap">
			<label>ニックネーム</label>
			<p>{{ $member->nickname}}</p>
		</div>

		<div class="element_wrap">
			<label>性別</label>
            @if($member->gender === 1)
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
			<p>{{ $member->email}}</p>
		</div>
    
        <a class="back-btn" href="/admin/form?id={{$member->id}}">編集</a>
    
        <a class="back-btn" href="{{ route('admin_member.destroy') }}"
            onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();">
            削除
        </a>
       
        <form id="delete-form" action="{{ route('admin_member.destroy',['$id'])}}" method="POST" class="d-none">
        <input type="hidden" value="{{$id}}" name="user_id">
                @csrf
        </form>


        @endforeach
    @endif
</div>
@endsection