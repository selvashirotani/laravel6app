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
        <script >
            // セレクトボックスの連動
            // 親カテゴリのselect要素が変更になるとイベントが発生

            $(document).on('change', '#category', function() {
                var cate_val = $(this).val();
                subcategory.disabled = false;
                $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/fetch/category',
                type: 'POST',
                data: {
                    "product_category_id" : cate_val
                },
                datatype: 'json',
                })
                .done(function(data) {    
                    // DBから受け取ったデータを子カテゴリのoptionにセット
                    $('#subcategory').append($('<option>').text("選択してください"));
                    $.each(data, function(key, value) {
                        $('#subcategory').append($('<option>').text(value.subcategory_name).attr('value', value.id));
                    })

                })

                .fail(function() {
                console.log('失敗');
                }); 

            });

       </script>

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
                        <select name = "category" id="category">
                        <!-- onchange=”createCategory(this.value)” 選択をする度にJavaScriptのcreateCategoryという関数を呼び出し -->
                        <!-- また関数を呼び出す際に選択した値を「this.value」にて渡しています -->
                            <option name="product_category_id" value="" selected>選択してください</option>
                            @foreach ($category as $index => $name)
                            @if((!empty($request->product_category_id) && $request->product_category_id == $index) || old('product_category_id') == $index )
                            <option value="{{$index}}" name="product_category_id" selected>{{$name}}</option>
                            @else
                            <option value="{{$index}}" name="product_category_id">{{$name}}</option>
                            @endif
                            @endforeach
                        </select>
                        
                        <select name = "subcategory" id="subcategory" disabled>
                            
                        </select>


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