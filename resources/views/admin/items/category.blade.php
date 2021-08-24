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
        <p>商品カテゴリ一覧</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{  url('/admin') }}">トップに戻る</a>
    </div>


</div class="header">


<div class="main">
<a class="submit-btn" href="{{ url('/admin/items/form') }}">商品カテゴリ登録</a>
<!-- 検索フォーム -->
    <div class="search">
        <form action="{{ route('admin_items.category') }}">
        @csrf
        <div class="element_wrap">
            <label for="category_id">ID</label>
            <input type="text" name="category_id" value="{{ old('category_id') }}" />
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
            <th>商品大カテゴリ</th>
            <th class="direction">@sortablelink('created_at', '登録日時▼')</th>
            <th>編集</th>
            <th>詳細</th>
        </tr>

        @if(!empty($items))
        @foreach ($items as $item)
        <tr>
            <td>{{$item->id}}</td>
            <td>{{$item->category_name}}</td>
            <td>{{$item->created_at}}</td>
            <td><a href="/admin/items/form?id={{$item->id}}">編集</a></td>
            <td><a href="/admin/items/form?id={{$item->id}}">詳細</a></td>
        </tr>
        @endforeach

    </table>
    
    {{ $items->appends(request()->input())->links('vendor.pagination.sample-pagination') }}

@endif

</div>
        
</body>
</html>