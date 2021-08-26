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
        <p>商品一覧</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{  url('/admin') }}">トップに戻る</a>
    </div>


</div class="header">


<div class="main">
<a class="submit-btn" href="{{ url('/admin/products/form') }}">商品登録</a>
<!-- 検索フォーム -->
    <div class="search">
        <form action="{{ route('admin_products.all') }}">
        @csrf
        <div class="element_wrap">
            <label for="products_id">ID</label>
            <input type="text" name="products_id" value="{{ old('products_id') }}" />
        </div>

        <div class="element_wrap">
            <label for="free_word">フリー ワード</label>
            <input type="text" name="free_word" value="{{ old('free_word') }}" />
        </div>

        <input type="submit" id="submit" name="btn_search" value="検索する" />
        </form>

    </div>
<!-- 検索フォーム -->

<!-- 一覧ここから -->
    
    <table>
        <tr>
            <th class="direction">@sortablelink('id','ID▼')</th>
            <th>商品名</th>
            <th class="direction">@sortablelink('created_at', '登録日時▼')</th>
            <th>編集</th>
            <th>詳細</th>
        </tr>

        @if(!empty($items))
        @foreach ($items as $item)
            @if(empty($item->deleted_at))
        <tr>
            <td>{{$item->id}}</td>
            <td><a href="/admin/products/detail?id={{$item->id}}">{{$item->name}}</a></td>
            <td>{{$item->created_at}}</td>
            <td><a href="/admin/products/form?id={{$item->id}}">編集</a></td>
            <td><a href="/admin/products/detail?id={{$item->id}}">詳細</a></td>
        </tr>
            @endif
        @endforeach

    </table>
    
    {{ $items->appends(request()->input())->links('vendor.pagination.sample-pagination') }}

@endif

</div>
        
</body>
</html>