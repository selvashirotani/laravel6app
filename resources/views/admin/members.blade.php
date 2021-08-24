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
        <p>会員一覧</p>
    </div>

    <div class = "right-column">
        <a class="headerbutton" href="{{  url('/admin') }}">トップに戻る</a>
    </div>


</div class="header">


<div class="main">
<a class="submit-btn" href="{{ url('/admin/form') }}">会員登録</a>
<!-- 検索フォーム -->
    <div class="search">
        <form action="{{ route('admin_member.all') }}">
        @csrf
        <div class="element_wrap">
            <label for="member_id">ID</label>
            <input type="text" name="member_id" value="{{ old('member_id') }}" />
        </div>

        <div class="element_wrap">
            <label for="name">性別</label>
            
            <label for="1">
                <input id="1" type="checkbox" name="gender[]" value="1" {{ old("gender") === "1"? 'checked="checked"' : '' }} >
                   男性
            </label>

            <label for="2">
                <input id="2" type="checkbox" name="gender[]" value="2" {{ old("gender") === "1"? 'checked="checked"' : '' }}>
                   女性
            </label>

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
            <th>氏名</th>
            <th>メールアドレス</th>
            <th>性別</th>
            <th class="direction">@sortablelink('created_at', '登録日時▼')</th>
            <th>編集</th>
            <th>詳細</th>
        </tr>

        @if(!empty($members))
        @foreach ($members as $member)
        <tr>
            <td>{{$member->id}}</td>
            <td><a href="/admin/members/detail?id={{$member->id}}">{{$member->name_sei}} {{$member->name_mei}}</a></td>
            <td>{{$member->email}}</td>
            <td>
            @if($member->gender === 1)
			男性
            @else
            女性
            @endif
            </td>
            <td>{{$member->created_at->format('Y/m/d')}}</td>
            <td><a href="/admin/form?id={{$member->id}}">編集</a></td>
            <td><a href="/admin/members/detail?id={{$member->id}}">詳細</a></td>
        </tr>
        @endforeach

    </table>
    
    {{ $members->appends(request()->input())->links('vendor.pagination.sample-pagination') }}

@endif

</div>
        
</body>
</html>