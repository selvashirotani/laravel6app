<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
<div class="header">
    
    <div class = "left-column">
    @if(!empty($products))
        <p>商品編集確認</p>
    @else
        <p>商品登録確認</p>
    @endif
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{  url('/admin/products/all') }}">一覧へ戻る</a>
    </div>


</div class="header">
<div class="main">
 

	

    <form method="post" action="{{ route('admin_products.send') }}" onsubmit="return checkNijyuSubmit();">
	@csrf

        <div class="element_wrap">
            <label for="id">ID</label>
            @if(!empty($input['id']))
                <p>{{$input['id']}}</p>
            @else
                <p>登録後に自動採番</p>
            @endif
        </div>

		<div class="element_wrap">
			<label>商品名</label>
			<p>{{ $input["name"] }}</p>
		</div>

        <div class="element_wrap">
			<label>商品カテゴリ</label>
			<p>
            @foreach ($category as $index => $name)
            @if($input["product_category_id"] == $index )
            {{$name}}
            @endif
            @endforeach
            > 
            @foreach ($subcategory as $index => $name)
            @if($input["product_subcategory_id"] == $index )
            {{$name}}
            @endif
            @endforeach

			
			</p>
		</div>

		<div class="element_wrap">
			<label>商品写真</label>
            
			@if(!empty($path_image_1))
			<p>写真1</p></br>
			<label></label>
			<img src="/storage/{{$path_image_1}}" style="width:auto;height:200px;"/>
            @elseif(!empty($products[0]["imege_1"]))
			<img src="/storage/{{$products[0]["imege_1"]}}" style="width:auto;height:200px;"/>
			@endif

			@if(!empty($path_image_2))
			</br>
			<label></label>
			<p>写真2</p></br>
			<label></label>
			<img src="/storage/{{$path_image_2}}" style="width:auto;height:200px;"/>
            @elseif(!empty($products[0]["imege_2"]))
			<img src="/storage/{{$products[0]["imege_2"]}}" style="width:auto;height:200px;"/>
			@endif

			@if(!empty($path_image_3))
			</br>
			<label></label>
			<p>写真3</p></br>
			<label></label>
			<img src="/storage/{{$path_image_3}}" style="width:auto;height:200px;"/>
            @elseif(!empty($products[0]["imege_3"]))
			<img src="/storage/{{$products[0]["imege_3"]}}" style="width:auto;height:200px;"/>
			@endif

			@if(!empty($path_image_4))
			</br>
			<label></label>
			<p>写真4</p></br>
			<label></label>
			<img src="/storage/{{$path_image_4}}" style="width:auto;height:200px;"/>
            @elseif(!empty($products[0]["imege_4"]))
			<img src="/storage/{{$products[0]["imege_4"]}}" style="width:auto;height:200px;"/>
			@endif
			
		</div>

		<div class="element_wrap">
			<label>商品説明</label>
			<p>{!! nl2br($input["product_content"]) !!}</p>
			
		</div>
		@if(!empty($products))
        <a class="submit-btn" href="/admin/products/form?id={{$products[0]["id"]}}">前に戻る</a>
        <input type="submit" name="btn_submit" id="btnSubmit" value="商品を編集する">
        @else
        <button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
        <input type="submit" name="btn_submit" id="btnSubmit" value="商品を登録する">
        @endif
		
		
	</form>
</div>
@endsection