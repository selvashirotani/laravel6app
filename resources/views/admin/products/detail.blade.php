<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin/members.css') }}" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- こちら参考に二重送信対策(2021080416:11)
    https://javascript.programmer-reference.com/js-prevention-twice-submit/ -->
    <script>
        function checkNijyuSubmit(){
        var obj = document.getElementById("btnSubmit");
        if(obj.disabled){
            //ボタンがdisabledならsubmitしない
            return false;
        }else{
            //ボタンがdisabledでなければ、ボタンをdisabledにした上でsubmitする
            obj.disabled = true;
            return true;
        }
        }
    </script>

</head>

<body>


<div class="header">
            
	<div class = "left-column">
	
		<p>商品詳細</p>

	</div>

	<div class = "right-column">
		<a class="headerbutton" href="{{  url('/admin/products/all') }}">一覧へ戻る</a>
	</div>


</div class="header">

<div class="main">

@if(!empty($product))

        <div class="element_wrap">
			<label>商品ID</label>
			<p>{{$product[0]["id"]}}</p>
		</div>

		<div class="element_wrap">
			<label>商品名</label>
			<p>{{$product[0]["name"]}}</p>
		</div>

		<div class="element_wrap">
			<label>商品カテゴリ</label>
			<p>
            @foreach ($category as $index => $name)
            @if($product[0]["product_category_id"] == $index )
            {{$name}}
            @endif
            @endforeach
            > 
            @foreach ($subcategory as $index => $name)
            @if($product[0]["product_subcategory_id"] == $index )
            {{$name}}
            @endif
            @endforeach

			
			</p>
		</div>

        <div class="element_wrap">
			<label>商品写真</label>
            
			@if(!empty($product[0]["imege_1"]))
			<p>写真1</p></br>
			<label></label>
			<img src="/storage/{{$product[0]["imege_1"]}}" style="width:auto;height:200px;"/>
            
			@endif

			@if(!empty($product[0]["imege_2"]))
			</br><label></label><p>写真2</p></br>
			<label></label>
			<img src="/storage/{{$product[0]["imege_2"]}}" style="width:auto;height:200px;"/>
            
			@endif

			@if(!empty($product[0]["imege_3"]))
			</br><label></label><p>写真3</p></br>
			<label></label>
			<img src="/storage/{{$product[0]["imege_3"]}}" style="width:auto;height:200px;"/>
            
			@endif

			@if(!empty($product[0]["imege_4"]))
			</br><label></label><p>写真4</p></br>
			<label></label>
			<img src="/storage/{{$product[0]["imege_4"]}}" style="width:auto;height:200px;"/>
            
			@endif

			
			
		</div>

		<div class="element_wrap">
			<label>商品説明</label>
			<p>{!! nl2br($product[0]["product_content"]) !!}</p>
			
		</div>
	</div>

	<div class="header">
		<div class="element_wrap">
			<label>総合評価</label>
			@if(0 < $evaluation && $evaluation <= 1)
			<p>★　　　　　1</p>
			@elseif(1 < $evaluation && $evaluation <= 2)
			<p>★★　　　　2</p>
			@elseif(2 < $evaluation && $evaluation <= 3)
			<p>★★★　　　3</p>
			@elseif(3 < $evaluation && $evaluation<= 4)
			<p>★★★★　　4</p>
			@elseif(4 < $evaluation && $evaluation<= 5)
			<p>★★★★★　5</p>
			@else
			<p>レビューはありません</p>
			@endif
			
		</div>
	</div>

<div class="main">

@if(!empty($reviews))
	@foreach($reviews as $review)
	<div class="under">
		<div class="element_wrap">
			<label>商品レビューID</label>
			<p>{{$review->id}}</p>
		</div>
		<div class="element_wrap">
			<label><a href="/admin/members/detail?id={{$review->member_id}}">{{$review->member_name}}</a></label>
			@if(0 < $review->evaluation && $review->evaluation <= 1)
			<p>★　　　　　1</p>
			@elseif(1 < $review->evaluation && $review->evaluation <= 2)
			<p>★★　　　　2</p>
			@elseif(2 < $review->evaluation && $review->evaluation <= 3)
			<p>★★★　　　3</p>
			@elseif(3 < $review->evaluation && $review->evaluation<= 4)
			<p>★★★★　　4</p>
			@elseif(4 < $review->evaluation && $review->evaluation<= 5)
			<p>★★★★★　5</p>
			@else
			<p>レビューはありません</p>
			@endif
		</div>
		<div class="element_wrap">
			<label>商品コメント</label>
			<p>{{$review->comment}}</p>
			<div class = "right-column">
			<a class="footerbutton" href="/admin/reviews/detail?id={{$review->id}}">商品レビュー詳細</a>
			</div>
		</div>
	</div>
	@endforeach
	{{ $reviews->appends(request()->input())->links('vendor.pagination.sample-pagination') }}
@endif

        <a class="back-btn" href="/admin/products/form?id={{$product[0]["id"]}}">編集</a>
    
        <a class="back-btn" href="{{ route('admin_products.destroy') }}"
            onclick="event.preventDefault();
                            document.getElementById('delete-form').submit();">
            削除
        </a>
       
        <form id="delete-form" action="{{ route('admin_products.destroy',['$id'])}}" method="POST" class="d-none">
        <input type="hidden" value="{{$product[0]["id"]}}" name="products_id">
                @csrf
        </form>

</div>

    @endif

	</body>
</html>