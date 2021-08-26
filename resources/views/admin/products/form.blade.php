<!DOCTYPE html>
<!--参照 https://nebikatsu.com/7177.html/ -->
<!-- layoutについて -->

<html>
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link href="{{ asset('css/admin/app.css') }}" rel="stylesheet">
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
            @if(!empty($products))
                <p>商品編集</p>
            @else
                <p>商品登録</p>
            @endif
            </div>
        
            <div class = "right-column">
                <a class="headerbutton" href="{{  url('/admin/products/all') }}">一覧へ戻る</a>
            </div>
        
        
        </div class="header">
    <div class="main">
    
            @if($errors->any())
                <div style="color:red;">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            
            <form method="post" action="{{ route('admin_products.post') }}" id="my_form" enctype="multipart/form-data">
            <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                @csrf
                <!-- これだけでcsrf対策 -->


                @if(!empty($products))
                
                @foreach ($products as $product)
                <div class="element_wrap">
                    <label for="id">ID</label>
                    <p>{{$product->id}}</p>
                    <input type="hidden" name="id" value="{{$product->id}}" /> 
                </div>
                <!-- 各要素はバリデーション後に戻ってくることがあるため、old()関数を使います -->
                <div class="element_wrap">
                    <label for="name">商品名</label>
                    <input type="text" name="name" value="@if(old('name')){{ old('name') }} @elseif($product->name){{$product->name}} @endif" />
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
                        @elseif($product->product_category_id  == $index )
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
                        @elseif($product->product_subcategory_id  == $index )
                        <option value="{{$index}}" selected>{{$name}}</option>
                        @else
                        <option value="{{$index}}" >{{$name}}</option>
                        @endif
                        @endforeach
                    </select>

                    <script>
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

                <!-- カテゴリ系ここまで -->
                <!-- ここから画像アップロード -->
                <div class="element_wrap">
                    <label for="image">商品写真</label>
                    <label>写真1</label>
                    <img id="imege_1_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_1))
                    <img id="imege_1_2" src="/storage/{{$path_image_1}}" style="width:auto;height:200px;"/>
                    @elseif(!empty($product->imege_1))
                    <img id="imege_1_2" src="/storage/{{$product->imege_1}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_1" name="imege_1">
                    <button type="button" name="imege_1">アップロード</button>
                    </br>

                    <label for="image"></label>
                    <label>写真2</label>
                    <img id="imege_2_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_2))
                    <img id="imege_2_2" src="/storage/{{$path_image_2}}" style="width:auto;height:200px;"/>
                    @elseif(!empty($product->imege_2))
                    <img id="imege_2_2" src="/storage/{{$product->imege_2}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_2" name="imege_2">
                    <button type="button" name="imege_2">アップロード</button>

                    </br>

                    <label for="image"></label>
                    <label>写真3</label>
                    <img id="imege_3_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_3))
                    <img id="imege_3_2" src="/storage/{{$path_image_3}}" style="width:auto;height:200px;"/>
                    @elseif(!empty($product->imege_3))
                    <img id="imege_3_2" src="/storage/{{$product->imege_3}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_3" name="imege_3">
                    <button type="button" name="imege_3">アップロード</button>

                    </br>

                    <label for="image"></label>
                    <label>写真4</label>
                    <img id="imege_4_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_4))
                    <img id="imege_4_2" src="/storage/{{$path_image_4}}" style="width:auto;height:200px;"/>
                    @elseif(!empty($product->imege_4))
                    <img id="imege_4_2" src="/storage/{{$product->imege_4}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_4" name="imege_4">
                    <button type="button" name="imege_4">アップロード</button>

                    
                </div>
                <!-- JavaScripts -->
                <script src="{{ asset('js/image_upload.js') }}"></script>
                

                <!-- ここまで画像アップロード -->
                

                <div class="element_wrap">
                    <label for="product_content">商品説明</label>
                    <textarea class='wide-text' name="product_content" value="@if(old('product_content')){{ old('product_content') }} @elseif($product->product_content){{$product->product_content}} @endif" >@if(old('product_content')){{ old('product_content') }} @elseif($product->product_content){{$product->product_content}} @endif</textarea>
                </div>

                @endforeach
                @else

<!-- if文ここまで -->

                <div class="element_wrap">
                    <label for="id">ID</label>
                    <p>登録後に自動採番</p> 
                </div>
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

                    <script>
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

                <!-- カテゴリ系ここまで -->
                <!-- ここから画像アップロード -->
                <div class="element_wrap">
                    <label for="image">商品写真</label>
                    <label>写真1</label>
                    <img id="imege_1_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_1))
                    <img id="imege_1_2" src="/storage/{{$path_image_1}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_1" name="imege_1">
                    <button type="button" name="imege_1">アップロード</button>
                    </br>

                    <label for="image"></label>
                    <label>写真2</label>
                    <img id="imege_2_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_2))
                    <img id="imege_2_2" src="/storage/{{$path_image_2}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_2" name="imege_2">
                    <button type="button" name="imege_2">アップロード</button>

                    </br>

                    <label for="image"></label>
                    <label>写真3</label>
                    <img id="imege_3_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_3))
                    <img id="imege_3_2" src="/storage/{{$path_image_3}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_3" name="imege_3">
                    <button type="button" name="imege_3">アップロード</button>

                    </br>

                    <label for="image"></label>
                    <label>写真4</label>
                    <img id="imege_4_up" style="width:auto;height:200px;" />
                    @if(!empty($path_image_4))
                    <img id="imege_4_2" src="/storage/{{$path_image_4}}" style="width:auto;height:200px;"/>
                    @endif
                    <input type="file" id="imege_4" name="imege_4">
                    <button type="button" name="imege_4">アップロード</button>

                    
                </div>
                <!-- JavaScripts -->
                <script src="{{ asset('js/image_upload.js') }}"></script>
                

                <!-- ここまで画像アップロード -->
                

                <div class="element_wrap">
                    <label for="product_content">商品説明</label>
                    <textarea class='wide-text' name="product_content" value="{{ old('product_content') }}" >{{ old('product_content') }}</textarea>
                </div>



                @endif


                <input type="submit" id="submit" name="btn_confirm" value="確認画面へ" />

            
     
            </form>

    </div>
        
</body>
</html>