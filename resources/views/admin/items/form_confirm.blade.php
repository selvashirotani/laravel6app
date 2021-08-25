<!DOCTYPE html>


@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
        <div class="header">
            
            <div class = "left-column">
            @if(!empty($input['id']))
                <p>商品カテゴリ編集確認</p>
            @else
                <p>商品カテゴリ登録確認</p>
            @endif
            </div>
        
            <div class = "right-column">
                <a class="headerbutton" href="{{  url('/admin/items/category') }}">一覧へ戻る</a>
            </div>
        
        
        </div class="header">

        <div class="main">
       
                <form method="post" action="{{ route('admin_items.send') }}" onsubmit="return checkNijyuSubmit();">
                <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                
                    @csrf
                    
                    <div class="element_wrap">
                        <label for="id">商品大カテゴリID</label>
                        @if(!empty($input['id']))
                            <p>{{$input['id']}}</p>
                        @else
                            <p>登録後に自動採番</p>
                        @endif
                    </div>

                    <div class="element_wrap">
                        <label for="category_name">商品大カテゴリ</label>              
                        <p>{{ $input["category_name"] }}</p>
                    </div>

                    <div class="element_wrap">
                        <label for="subcategory_name">商品小カテゴリ</label>
                        
                        <p>{{ $input["subcategory_name_1"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_2"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_3"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_4"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_5"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_6"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_7"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_8"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_9"] }}</p>
                        </br>
                        <label for="subcategory_name"></label>
                        <p>{{ $input["subcategory_name_10"] }}</p>
                        
                    </div>

                    <button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
                    @if(!empty($input['id']))
                    <input type="submit" name="btn_submit" id="btnSubmit" value="編集完了">
                    @else
                    <input type="submit" name="btn_submit" id="btnSubmit" value="登録完了">
                    @endif
                    
                </form>
        </div>
@endsection