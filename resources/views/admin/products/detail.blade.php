<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')

<div class="header">
            
	<div class = "left-column">
	
		<p>商品カテゴリ詳細</p>

	</div>

	<div class = "right-column">
		<a class="headerbutton" href="{{  url('/admin/items/category') }}">一覧へ戻る</a>
	</div>


</div class="header">

<div class="main">
@if(!empty($categories))

        <div class="element_wrap">
			<label>商品大カテゴリID</label>
			<p>{{$category[0]["id"]}}</p>
		</div>

		<div class="element_wrap">
			<label>商品大カテゴリ</label>
			<p>{{$category[0]["category_name"]}}</p>
		</div>

        <div class="element_wrap">
			<label>商品小カテゴリ</label>
			<p>{{$category[0]["subcategory_name"]}}</p>
		</div>

		@if(!empty($category[1]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[1]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[2]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[2]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[3]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[3]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[4]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[4]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[5]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[5]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[6]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[6]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[7]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[7]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[8]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[8]["subcategory_name"]}}</p>
		</div>

		@endif

		@if(!empty($category[9]["subcategory_name"]))

		<div class="element_wrap">
			<label></label>
			<p>{{$category[9]["subcategory_name"]}}</p>
		</div>

		@endif
    
        <a class="back-btn" href="/admin/items/form?id={{$category[0]["id"]}}">編集</a>
    
        <a class="back-btn" href="{{ route('admin_items.destroy') }}"
            onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();">
            削除
        </a>
       
        <form id="delete-form" action="{{ route('admin_items.destroy',['$id'])}}" method="POST" class="d-none">
        <input type="hidden" value="{{$category[0]["id"]}}" name="category_id">
                @csrf
        </form>



    @endif
</div>
@endsection