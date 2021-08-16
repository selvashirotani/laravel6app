

// 参考 https://javascript.programmer-reference.com/jquery-image-preview/

// すべて非表示にする
$('button[name=imege_2]').attr('style', 'display: none;');
$('button[name=imege_3]').attr('style', 'display: none;');
$('button[name=imege_4]').attr('style', 'display: none;');
//写真1
$(function(){
    
    $('button[name=imege_1]').click(function(){
        $('input[name=imege_1]').trigger('click'); //アップロードのボタンをファイル選択のボタンってことにする。
        

        $('#imege_1').change(function(e){ //ファイルの画像変わったら（アップロードされたら）
            $('button[name=imege_2]').removeAttr('style');
            $('#imege_1_2').attr('style', 'display: none;');
        //ファイルオブジェクトを取得する
        var file = e.target.files[0]; ///選択ファイルを配列形式で取得
        var file_size = e.target.files[0].size;
        var reader = new FileReader(); //FileReader クラスで利用可能なプロパティhttps://hakuhin.jp/js/file_reader.html#FILE_READER_01
        
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
        }

        //画像の容量大きすぎたらエラー
        if(10485760 < file_size){
        alert("画像ファイルをは10MB以内にしてください。");
        return false;
        }
    
        //アップロードした画像を設定する
        reader.onload = (function(file){
            return function(e){
                $("#imege_1_up").attr("src", e.target.result); //id="imege_1_up"のsrcにファイル名いれる。
                $("#imege_1_up").attr("title", file.name);
            };
        })(file);

        reader.readAsDataURL(file); //FileReaderのメソッド
    
        });

    });
    
});

        


//写真2
$(function(){
            
    $('button[name=imege_2]').click(function(){
        $('input[name=imege_2]').trigger('click'); //アップロードのボタンをファイル選択のボタンってことにする。
        
        $('#imege_2').change(function(e){ //ファイルの画像変わったら（アップロードされたら）
            $('button[name=imege_2]').removeAttr('style');
            $('button[name=imege_3]').removeAttr('style');
            $('#imege_2_2').attr('style', 'display: none;');
        //ファイルオブジェクトを取得する
        var file = e.target.files[0]; ///選択ファイルを配列形式で取得
        var file_size = e.target.files[0].size;
        var reader = new FileReader(); //FileReader クラスで利用可能なプロパティhttps://hakuhin.jp/js/file_reader.html#FILE_READER_01
    
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
        }

        //画像の容量大きすぎたらエラー
        if(10485760 < file_size){
        alert("画像ファイルをは10MB以内にしてください。");
        return false;
        }
    
        //アップロードした画像を設定する
        reader.onload = (function(file){
            return function(e){
                $("#imege_2_up").attr("src", e.target.result); //id="imege_1_up"のsrcにファイル名いれる。
                $("#imege_2_up").attr("title", file.name);
            };
        })(file);

        reader.readAsDataURL(file); //FileReaderのメソッド
    
        });

    });
    
});

//写真3
$(function(){
            
    $('button[name=imege_3]').click(function(){
        $('input[name=imege_3]').trigger('click'); //アップロードのボタンをファイル選択のボタンってことにする。
        
        $('#imege_3').change(function(e){ //ファイルの画像変わったら（アップロードされたら）
            $('button[name=imege_2]').removeAttr('style');
            $('button[name=imege_3]').removeAttr('style');
            $('button[name=imege_4]').removeAttr('style');
            $('#imege_3_2').attr('style', 'display: none;');
        //ファイルオブジェクトを取得する
        var file = e.target.files[0]; ///選択ファイルを配列形式で取得
        var file_size = e.target.files[0].size;
        var reader = new FileReader(); //FileReader クラスで利用可能なプロパティhttps://hakuhin.jp/js/file_reader.html#FILE_READER_01
    
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
        }

        //画像の容量大きすぎたらエラー
        if(10485760 < file_size){
        alert("画像ファイルをは10MB以内にしてください。");
        return false;
        }
    
        //アップロードした画像を設定する
        reader.onload = (function(file){
            return function(e){
                $("#imege_3_up").attr("src", e.target.result); //id="imege_1_up"のsrcにファイル名いれる。
                $("#imege_3_up").attr("title", file.name);
            };
        })(file);

        reader.readAsDataURL(file); //FileReaderのメソッド
    
        });

    });
    
});

   

//写真4
$(function(){
            
    $('button[name=imege_4]').click(function(){
        $('input[name=imege_4]').trigger('click'); //アップロードのボタンをファイル選択のボタンってことにする。
        $('button[name=imege_2]').removeAttr('style');
        $('button[name=imege_3]').removeAttr('style');
        $('button[name=imege_4]').removeAttr('style');
        $('#imege_4').change(function(e){ //ファイルの画像変わったら（アップロードされたら）
            $('#imege_4_2').attr('style', 'display: none;');
        //ファイルオブジェクトを取得する
        var file = e.target.files[0]; ///選択ファイルを配列形式で取得
        var file_size = e.target.files[0].size;
        var reader = new FileReader(); //FileReader クラスで利用可能なプロパティhttps://hakuhin.jp/js/file_reader.html#FILE_READER_01
    
        //画像でない場合は処理終了
        if(file.type.indexOf("image") < 0){
        alert("画像ファイルを指定してください。");
        return false;
        }

        //画像の容量大きすぎたらエラー
        if(10485760 < file_size){
        alert("画像ファイルをは10MB以内にしてください。");
        return false;
        }
    
        //アップロードした画像を設定する
        reader.onload = (function(file){
            return function(e){
                $("#imege_4_up").attr("src", e.target.result); //id="imege_1_up"のsrcにファイル名いれる。
                $("#imege_4_up").attr("title", file.name);
            };
        })(file);

        reader.readAsDataURL(file); //FileReaderのメソッド
    
        });

    });
    
});

