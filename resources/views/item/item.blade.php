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

    </head>
    
    <body>

        <div class="main">
       
            <h1>商品登録</h1>
            
                @if($errors->any())
                    <div style="color:red;">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('item.post') }}" enctype="multipart/form-data">
                <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                    @csrf
                    <!-- これだけでcsrf対策 -->

                    <!-- 各要素はバリデーション後に戻ってくることがあるため、old()関数を使います -->
                    <div class="element_wrap">
                        <label for="name">商品名</label>
                        <input type="text" name="name" value="{{ old('name') }}" />
                    </div>

                    <div class="element_wrap">
                        <label for="category">商品カテゴリ</label>
                        <select name = "product_category_id" id="category">
                        <!-- onchange=”createCategory(this.value)” 選択をする度にJavaScriptのcreateCategoryという関数を呼び出し -->
                        <!-- また関数を呼び出す際に選択した値を「this.value」にて渡しています -->
                            <option value="" >選択してください</option>
                            @foreach ($category as $index => $name)
                            @if((!empty($request->product_category_id) && $request->product_category_id == $index) || old('product_category_id') == $index )
                            <option value="{{$index}}" selected>{{$name}}</option>
                            @else
                            <option value="{{$index}}" >{{$name}}</option>
                            @endif
                            @endforeach
                        </select>
                        
                        <select name = "product_subcategory_id" id="subcategory">
                            <option id="not_select" value="">選択してください</option>
                            @foreach ($subcategory as $index => $name)
                            @if((!empty($request->product_subcategory_id) && $request->product_subcategory_id == $index) || old('product_subcategory_id') == $index )
                            <option value="{{$index}}" selected>{{$name}}</option>
                            @else
                            <option value="{{$index}}" >{{$name}}</option>
                            @endif
                            @endforeach
                        </select>

                        <script >
                            // セレクトボックスの連動
                            // 親カテゴリのselect要素が変更になるとイベントが発生
                            var value_sub = $('#subcategory').val();
                            var value = $('#category').val();
                            //サブカテゴリに値入ってなかったらサブカテゴリは見えなくする。
                            if(value_sub==""){
                                $('#subcategory > option').attr('style', 'display: none;');
                                jQuery(function(){
                                function some_handler(){
                                    //実行したい内容をここに書く
                                    subcategory.disabled = false;
                                    var cate_val = $(this).val();
                                    var select = document.getElementById('subcategory');
                                    var options = select.options;
                                    options[0].selected =true;

                                    // すべて非表示にする
                                    $('#subcategory > option').attr('style', 'display: none;');
                                    //選択してくださいを表示
                                    $('#subcategory > #not_select').attr('selected',true).removeAttr('style');

                                    $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '/fetch/category',
                                    type: 'POST',
                                    data: {
                                        "product_category_id" : cate_val,
                                    },
                                    datatype: 'json',
                                    })
                                    .done(function(data) {

                                        // 有効の場合
                                        $.each(data, function(key, value) {  
                                            // 紐づいている子カテゴリのIDなので非表示させる
                                            $('#subcategory > option[value="'+value.id+'"]').removeAttr('style');
                                        })                          
                                    
                                    })
                                    .fail(function() {
                                    console.log('失敗');
                                    }); 
                                }

                                //どちらのイベントでも同じ関数が実行される
                                $("#category").change(some_handler);
                                $("#category").focus(some_handler);
                            });
                            }else{ //サブカテゴリに値入ってるとき
                                //サブカテゴリが変更されたら
                                jQuery(function(){
                                function subchange(){
                                     //ajax通信
                                    $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '/fetch/category',
                                    type: 'POST',
                                    data: {
                                        "product_category_id" : value,
                                    },
                                    datatype: 'json',
                                    })
                                    .done(function(data) {
                                        // すべて非表示にする
                                        $('#subcategory > option').attr('style', 'display: none;');
                                        //選択してくださいを表示
                                        $('#subcategory > #not_select').attr('selected',true).removeAttr('style');

                                        // 有効の場合
                                        $.each(data, function(key, value) {  
                                        
                                        // 紐づいている子カテゴリのIDなので非表示させる
                                        $('#subcategory > option[value="'+value.id+'"]').removeAttr('style');
                                        })                          

                                    })
                                    .fail(function() {
                                    console.log('失敗');
                                    }); 

                                 }
                                    //どちらのイベントでも同じ関数が実行される
                                    $("#subcategory").change(subchange);
                                    $("#subcategory").focus(subchange);
                                });

                            
                                jQuery(function(){
                                function nextchange(){
                                    value = $('#category').val();
                                    var select = document.getElementById('subcategory');
                                    var options = select.options;
                                    options[0].selected =true;
                                    
                                    $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    url: '/fetch/category',
                                    type: 'POST',
                                    data: {
                                        "product_category_id" : value,
                                    },
                                    datatype: 'json',
                                    })
                                    .done(function(data) {
                                        // すべて非表示にする
                                        $('#subcategory > option').attr('style', 'display: none;');
                                        subcategory.disabled = false;
                                        //選択してくださいを表示
                                        $('#subcategory > #not_select').removeAttr('style');
                                        // 有効の場合
                                        $.each(data, function(key, value) {  
                                            // 紐づいている子カテゴリのIDなので非表示させる
                                            $('#subcategory > option[value="'+value.id+'"]').removeAttr('style');
                                        })                          
                                    
                                    })
                                    .fail(function() {
                                    console.log('失敗');
                                    }); 
                                }

                                    //どちらのイベントでも同じ関数が実行される
                                    $("#category").change(nextchange);
                                    
                                });
                            
                            }

                        </script>


                    </div>

                    <div class="element_wrap">
                        <label for="image">商品写真</label>
                        <input id="image" type="file" name="imege_1">
                        <input id="image" type="file" name="imege_2">
                        <input id="image" type="file" name="imege_3">
                        <input id="image" type="file" name="imege_4">
                    </div>

                    @if (Route::has('item.post'))
                    <!-- バリデーションであかんかったときにも画像は表示する。 -->

                    @endif

                    <div class="element_wrap">
                        <label for="product_content">商品説明</label>
                        <textarea class='wide-text' name="product_content" value="{{ old('product_content') }}" >{{ old('product_content') }}</textarea>
                    </div>

                    <input type="submit" id="submit" name="btn_confirm" value="確認画面へ" />
                    <a class="back-btn" href="{{ url('/') }}">トップに戻る</a>
                </form>

        </div>
        
    </body>

    
</html>