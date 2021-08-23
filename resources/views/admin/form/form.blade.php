<!DOCTYPE html>


@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
        <div class="header">
            
            <div class = "left-column">
            @if(!empty($members))
                <p>会員編集</p>
            @else
                <p>会員登録</p>
            @endif
            </div>
        
            <div class = "right-column">
                <a class="headerbutton" href="{{  url('/admin/members') }}">一覧へ戻る</a>
            </div>
        
        
        </div class="header">

        <div class="main">
        <!-- 2021080223:35 エラー文の表示 -->
        @if($errors->any())
            <div style="color:red;">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <!-- ここまで -->  
                <form method="post" action="{{ route('admin_member.post') }}">
                <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                    @csrf
                    
                    @if(!empty($members))
                    @foreach ($members as $member)
                    <div class="element_wrap">
                        <label for="id">ID</label>
                        <p>{{$member->id}}</p>
                        <input type="hidden" name="id" value="{{$member->id}}" /> 
                    </div>

                    <div class="element_wrap">
                        <label for="name">氏名</label>              
                        <p>姓</p>
                        <input type="text" name="name_sei" value="@if(old('name_sei')){{ old('name_sei') }} @elseif($member->name_sei){{$member->name_sei}} @endif" />
                        <p>名</p>
                        <input type="text" name="name_mei" value="@if(old('name_mei')){{ old('name_mei') }} @elseif($member->name_mei){{$member->name_mei}} @endif" />
                    </div>

                    <div class="element_wrap">
                        <label for="nickname">ニックネーム</label>
                        <input type="text" name="nickname" value="@if(old('nickname')){{ old('nickname') }} @elseif($member->nickname){{$member->nickname}} @endif" />  
                    </div>

                    <div class="element_wrap">
                        <label for="name">性別</label>
                        @if(old('gender'))
                        @foreach (config('master') as $index => $value)
                        <label for="{{$value}}">
                            <input id="{{$value}}" type="radio" name="gender" value="{{$index}}" 
                                @if(old('master')=="{{$index}}") checked @endif 
                                @if(empty(old()) and $index == ('master') ) checked="checked"
                                    @elseif($index == old('gender'))) checked="checked"
                                    @endif/>
                                {{$value}}
                        </label>
                        @endforeach
                        @else
                        @foreach (config('master') as $index => $value)
                        <label for="{{$value}}">
                            <input id="{{$value}}" type="radio" name="gender" value="{{$index}}" 
                                @if($member->gender =="{{$index}}") checked @endif 
                                @if(empty($member->gender) and $index == ('master') ) checked="checked"
                                    @elseif($index == $member->gender)) checked="checked"
                                    @endif/>
                                {{$value}}
                        </label>
                        @endforeach
                        @endif
                    </div>

                    <div class="element_wrap">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" value="{{ old('password') }}" /> 
                    </div>

                    <div class="element_wrap">
                        <label for="password_confirmation">パスワード確認</label>  
                        <input type="password" name="password_confirmation" />
                        
                    </div>

                    <div class="element_wrap">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" value="@if(old('email')){{ old('email') }} @elseif($member->email){{$member->email}} @endif" />
                    </div>

                    @endforeach
                @else
                    <div class="element_wrap">
                        <label for="id">ID</label>
                        <p>登録後に自動採番</p> 
                    </div>

                    <div class="element_wrap">
                        <label for="name">氏名</label>              
                        <p>姓</p>
                        <input type="text" name="name_sei" value="{{ old('name_sei') }}" />
                        <p>名</p>
                        <input type="text" name="name_mei" value="{{ old('name_mei') }}" />
                    </div>

                    <div class="element_wrap">
                        <label for="nickname">ニックネーム</label>
                        <input type="text" name="nickname" value="{{ old('nickname') }}" />  
                    </div>
                    
                    <div class="element_wrap">
                        <label for="name">性別</label>
                        @foreach (config('master') as $index => $value)
                        <label for="{{$value}}">
                            <input id="{{$value}}" type="radio" name="gender" value="{{$index}}" 
                                @if(old('master')=="{{$index}}") checked @endif 
                                @if(empty(old()) and $index == ('master') ) checked="checked"
                                    @elseif($index == old('gender'))) checked="checked"
                                    @endif/>
                                {{$value}}
                        </label>
                        @endforeach
                    </div>

                    <div class="element_wrap">
                        <label for="password">パスワード</label>
                        <input type="password" name="password" value="{{ old('password') }}" /> 
                    </div>

                    <div class="element_wrap">
                        <label for="password_confirmation">パスワード確認</label>  
                        <input type="password" name="password_confirmation" />
                        
                    </div>

                    <div class="element_wrap">
                        <label for="email">メールアドレス</label>
                        <input type="email" name="email" value="{{ old('email') }}" />
                    </div>

                    @endif

                    <input type="submit" name="btn_confirm" value="確認画面へ" />
                    
                </form>
        </div>
@endsection