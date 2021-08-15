
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

