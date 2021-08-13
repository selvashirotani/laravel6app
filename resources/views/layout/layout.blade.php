
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
        <script src="{{ asset('js/image_upload.js') }}"></script>
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
    @yield('form')
    @yield('top')

    </body>
</html>