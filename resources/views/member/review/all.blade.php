<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my/review.css') }}" rel="stylesheet">
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
            <p> 商品レビュー管理</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{ url('/') }}">トップに戻る</a>
    </div>

</div>

<div class="main">

<!-- 一覧ここから -->

@if(!empty($reviews))
    @foreach ($reviews as $review)
    <div class="reviews">

        @if(!empty($review->imege_1))
        <img class="img_right" src="/storage/{{$review->imege_1}}" style="width:auto;height:200px;"/>
        @endif
        <p class="item_cate">
			@if($review->product_subcategory_id == "1")
			インテリア > 収納家具
			@elseif($review->product_subcategory_id == "2")
			インテリア > 寝具
			@elseif($review->product_subcategory_id == "3")
			インテリア > ソファ
			@elseif($review->product_subcategory_id == "4")
			インテリア > ベッド
			@elseif($review->product_subcategory_id == "5")
			インテリア > 照明
			@elseif($review->product_subcategory_id == "6")
			家電 > テレビ
			@elseif($review->product_subcategory_id == "7")
			家電 > 掃除機
			@elseif($review->product_subcategory_id == "8")
			家電 > エアコン
			@elseif($review->product_subcategory_id == "9")
			家電 > 冷蔵庫
			@elseif($review->product_subcategory_id == "10")
			家電 > レンジ
			@elseif($review->product_subcategory_id == "11")
			ファッション > トップス
			@elseif($review->product_subcategory_id == "12")
			ファッション > ボトム
			@elseif($review->product_subcategory_id == "13")
			ファッション > ワンピース
			@elseif($review->product_subcategory_id == "14")
			ファッション > ファッション小物
			@elseif($review->product_subcategory_id == "15")
			ファッション > ドレス
			@elseif($review->product_subcategory_id == "16")
			美容 > ネイル
			@elseif($review->product_subcategory_id == "17")
			美容 > アロマ
			@elseif($review->product_subcategory_id == "18")
			美容 > スキンケア
			@elseif($review->product_subcategory_id == "19")
			美容 > 香水
			@elseif($review->product_subcategory_id == "20")
			美容 > メイク
			@elseif($review->product_subcategory_id == "21")
			本・雑誌 > 旅行
			@elseif($review->product_subcategory_id == "22")
			本・雑誌 > ホビー
			@elseif($review->product_subcategory_id == "23")
			本・雑誌 > 写真集
			@elseif($review->product_subcategory_id == "24")
			本・雑誌 > 小説
			@elseif($review->product_subcategory_id == "25")
			本・雑誌 > ライフスタイル
			@endif
        </p>
        <p class="item_name">{{$review->name}}</p>

        @if($review->evaluation == "1")
        <p class="review_evaluation">★　　　　　1</p>
        @elseif($review->evaluation == "2")
        <p class="review_evaluation">★★　　　　2</p>
        @elseif($review->evaluation == "3")
        <p class="review_evaluation">★★★　　　3</p>
        @elseif($review->evaluation == "4")
        <p class="review_evaluation">★★★★　　4</p>
        @elseif($review->evaluation == "5")
        <p class="review_evaluation">★★★★★　5</p>
        @endif


        <p class="review_comment">{{ Str::limit($review->comment,32, '...') }}</p>

        <a class="btn-1" href="/member/detail/review/edit?id={{$review->reviews_id}}">レビュー編集</a>
        <a class="btn-2" href="/member/detail/review/edit/delete?id={{$review->reviews_id}}">レビュー削除</a>

    </div>

    @endforeach

    {{ $reviews->appends(request()->input())->links('vendor.pagination.sample-pagination') }}

@endif





<a class="back-btn" href="/member/detail?id={{Auth::user()->id}}">マイページに戻る</a>
</div>

</body>
</html>