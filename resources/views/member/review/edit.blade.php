<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
            <p> 商品レビュー編集</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{ url('/') }}">トップに戻る</a>
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

        <p class="item_name">{{$item->name}}</p>
       
        @if(0 < $item->evaluation && $item->evaluation <= 1)
        <p class="item_review">総合評価　★　　　　　1</p>
        @elseif(1 < $item->evaluation && $item->evaluation <= 2)
        <p class="item_review">総合評価　★★　　　　2</p>
        @elseif(2 < $item->evaluation && $item->evaluation <= 3)
        <p class="item_review">総合評価　★★★　　　3</p>
        @elseif(3 < $item->evaluation && $item->evaluation<= 4)
        <p class="item_review">総合評価　★★★★　　4</p>
        @elseif(4 < $item->evaluation && $item->evaluation<= 5)
        <p class="item_review">総合評価　★★★★★　5</p>
        @else
        <p class="item_review">レビューなし</p>
        @endif
        
    </div>

    @endforeach

@endif

@if($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!-- レビューのフォーム -->
<form method="post" action="{{ route('review.edit') }}" >
@csrf
@if(!empty($items))
    @foreach ($items as $item)
    <div class="element_wrap">
        <label for="evaluation">商品評価</label>
        <select name = "evaluation" >
            <option value="" >選択してください</option>
            @if(old('evaluation'))
            @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @if(old('evaluation')=="$i") selected @endif >{{ $i }}</option>
            @endfor
            @else
            @for ($i = 1; $i <= 5; $i++)
            <option value="{{ $i }}" @if($item->evaluation =="$i") selected @endif >{{ $i }}</option>
            @endfor
            @endif
        </select>
    </div>

    <div class="element_wrap">
        <label for="comment">商品説明</label>
        <textarea class='wide-text' name="comment" value="@if(old('comment')){{old('comment') }} @else {{$item->comment}} @endif" >
        @if(old('comment')){{old('comment') }} @else {{$item->comment}} @endif
        </textarea>
    </div>
    <input type="hidden" id="submit" name="review_id" value="{{$id}}" />
    <input type="hidden" id="submit" name="product_id" value="{{$item->product_id}}" />
    <input type="submit" id="submit" name="btn_confirm" value="商品レビュー編集確認" />
    @endforeach
@endif
</form>
<!-- ここまで -->






<a class="back-btn" href="/member/detail/review?id={{ Auth::user()->id}}">レビュー管理に戻る</a>
</div>

</body>
</html>