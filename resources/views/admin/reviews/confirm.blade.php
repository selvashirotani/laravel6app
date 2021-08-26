<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/item_all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/review.css') }}" rel="stylesheet">
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
            <p> 商品レビュー編集確認</p>
    </div>

    <div class = "right-column">
    <a class="headerbutton" href="{{  url('/admin/reviews/all') }}">一覧へ戻る</a>
    </div>

</div>

<div class="main">

<!-- 一覧ここから -->
@if(!empty($items))
    @foreach ($items as $item)
    <div class="items">
        
        @if(!empty($item->imege_1))
        <img class="img_right" src="/storage/{{$item->imege_1}}" style="width:auto;height:200px;"/>
        @endif

        <p class="item_review">商品ID　{{$item->product_id}}</p>
        <p class="item_name">{{$item->name}}</p>
       
        @if(0 < $evaluation && $evaluation <= 1)
        <p class="review">総合評価　★　　　　　1</p>
        @elseif(1 < $evaluation && $evaluation <= 2)
        <p class="review">総合評価　★★　　　　2</p>
        @elseif(2 < $evaluation && $evaluation <= 3)
        <p class="review">総合評価　★★★　　　3</p>
        @elseif(3 < $evaluation && $evaluation<= 4)
        <p class="review">総合評価　★★★★　　4</p>
        @elseif(4 < $evaluation && $evaluation<= 5)
        <p class="review">総合評価　★★★★★　5</p>
        @else
        <p class="review">レビューなし</p>
        @endif
        
    </div>

    @endforeach

@endif

<form method="post" action="{{ route('admin_reviews.send') }}" onsubmit="return checkNijyuSubmit();">
	@csrf
        <div class="element_wrap">
            <label for="review_id">ID</label>  
            <p>{{$item->review_id}}</p> 
        </div>
		<div class="element_wrap">
			<label>商品評価</label>
			<p>{{ $input["evaluation"] }}</p>
		</div>
        <div class="element_wrap">
			<label>商品コメント</label>
			<p>{!! nl2br($input["comment"]) !!}</p>
		
		</div>
        <input type="hidden" name="review_id"  value="{{$item->review_id}}">
    <input type="submit" name="btn_submit" id="btnSubmit" value="登録完了">
    <button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
</form>


</div>

</body>
</html>