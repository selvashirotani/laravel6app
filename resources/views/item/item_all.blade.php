<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
            
    @guest

        <div class = "left-column">
             <p> 商品一覧</p>
        </div>


        
    @else
        <div class = "left-column">
             <p> 商品一覧</p>
        </div>

        <div class = "right-column">
            <a class="headerbutton" href="{{ url('/item') }}">新規商品登録</a>
        </div>
    @endguest

</div class="header">


<div class="main">
<!-- 検索フォーム -->
    <div class="search">
        <form action="{{ route('itemall.show') }}">
        @csrf
        <div class="element_wrap">
            <label for="category">カテゴリ</label>
            <select name = "product_category_id" id="category">
            <!-- onchange=”createCategory(this.value)” 選択をする度にJavaScriptのcreateCategoryという関数を呼び出し -->
            <!-- また関数を呼び出す際に選択した値を「this.value」にて渡しています -->
                <option value="" >カテゴリ</option>
                @foreach ($category as $index => $name)
                @if((!empty($request->product_category_id) && $request->product_category_id == $index) || old('product_category_id') == $index )
                <option value="{{$index}}" selected>{{$name}}</option>
                @else
                <option value="{{$index}}" >{{$name}}</option>
                @endif
                @endforeach
            </select>
            
            <select name = "product_subcategory_id" id="subcategory">
                <option id="not_select" value="">サブカテゴリ</option>
                @foreach ($subcategory as $index => $name)
                @if((!empty($request->product_subcategory_id) && $request->product_subcategory_id == $index) || old('product_subcategory_id') == $index )
                <option value="{{$index}}" selected>{{$name}}</option>
                @else
                <option value="{{$index}}" >{{$name}}</option>
                @endif
                @endforeach
            </select>


            <!-- JavaScripts -->
            <script src="{{ asset('js/category.js') }}"></script>
        </div>


        <div class="element_wrap">
            <label for="free_word">フリー ワード</label>
            <input type="text" name="free_word" value="{{ old('free_word') }}" />
        </div>

        <input type="submit" id="submit" name="btn_search" value="商品検索" />
        </form>

    </div>
<!-- 検索フォーム -->

<!-- 一覧ここから -->
@if(!empty($items))
    @foreach ($items as $item)
    <div class="items">
        <img class="img_right" src="/storage/{{$item->imege_1}}" style="width:auto;height:200px;"/>
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
        <p class="item_name">{{$item->name}}</p>   
            
    </div>
    
    @endforeach

    {{ $items->appends(request()->input())->links('vendor.pagination.sample-pagination') }}

@endif


<a class="back-btn" href="{{ url('/') }}">トップに戻る</a>

</div>
        
</body>
</html>