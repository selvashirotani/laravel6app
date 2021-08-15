<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/item_detail.css') }}" rel="stylesheet">
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
            <p> 商品詳細</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{ url('/') }}">トップに戻る</a>
    </div>

</div class="header">

<div class="main">
<!-- 一覧ここから -->
@if(!empty($items))
    @foreach ($items as $item)
    <div class="items">
        <p class="item_cate">
			@if($item->product_subcategory_id == "1")
			インテリア > 収納家具
			@elseif($item->product_subcategory_id == "2")
			インテリア > 寝具
			@elseif($item->product_subcategory_id == "3")
			インテリア > ソファ
			@elseif($item->product_subcategory_id == "4")
			インテリア > ベッド
			@elseif($item->product_subcategory_id == "5")
			インテリア > 照明
			@elseif($item->product_subcategory_id == "6")
			家電 > テレビ
			@elseif($item->product_subcategory_id == "7")
			家電 > 掃除機
			@elseif($item->product_subcategory_id == "8")
			家電 > エアコン
			@elseif($item->product_subcategory_id == "9")
			家電 > 冷蔵庫
			@elseif($item->product_subcategory_id == "10")
			家電 > レンジ
			@elseif($item->product_subcategory_id == "11")
			ファッション > トップス
			@elseif($item->product_subcategory_id == "12")
			ファッション > ボトム
			@elseif($item->product_subcategory_id == "13")
			ファッション > ワンピース
			@elseif($item->product_subcategory_id == "14")
			ファッション > ファッション小物
			@elseif($item->product_subcategory_id == "15")
			ファッション > ドレス
			@elseif($item->product_subcategory_id == "16")
			美容 > ネイル
			@elseif($item->product_subcategory_id == "17")
			美容 > アロマ
			@elseif($item->product_subcategory_id == "18")
			美容 > スキンケア
			@elseif($item->product_subcategory_id == "19")
			美容 > 香水
			@elseif($item->product_subcategory_id == "20")
			美容 > メイク
			@elseif($item->product_subcategory_id == "21")
			本・雑誌 > 旅行
			@elseif($item->product_subcategory_id == "22")
			本・雑誌 > ホビー
			@elseif($item->product_subcategory_id == "23")
			本・雑誌 > 写真集
			@elseif($item->product_subcategory_id == "24")
			本・雑誌 > 小説
			@elseif($item->product_subcategory_id == "25")
			本・雑誌 > ライフスタイル
			@endif
        </p>
        <p class="item_name">{{$item->name}}　　　更新日時；{{$item->updated_at->format('Ymd')}}</p>
        @if(!empty($item->imege_1))
        <img class="img_right" src="/storage/{{$item->imege_1}}" style="width:auto;height:200px;"/>
        @endif

        @if(!empty($item->imege_2))
        <img class="img_right" src="/storage/{{$item->imege_2}}" style="width:auto;height:200px;"/>
        @endif

        @if(!empty($item->imege_3))
        <img class="img_right" src="/storage/{{$item->imege_3}}" style="width:auto;height:200px;"/>
        @endif

        @if(!empty($item->imege_4))
        <img class="img_right" src="/storage/{{$item->imege_4}}" style="width:auto;height:200px;"/>
        @endif

        <p>■ 商品説明</p>
        <p>{{$item->product_content}}</p>
            
    </div>
    
    @endforeach


@endif

<?php
    if(!empty($_SERVER['HTTP_REFERER'])){
        $prev_url = parse_url($_SERVER['HTTP_REFERER']);
    }
    
?>

@if(!empty($prev_url["query"]))
    <a class="back-btn" href="{{ $prev_url["path"]}}?{{$prev_url["query"]}}">商品一覧に戻る</a>
@else
    <a class="back-btn" href="{{ url('/item/all') }}">商品一覧に戻る</a>
@endif
</div>

</body>
</html>