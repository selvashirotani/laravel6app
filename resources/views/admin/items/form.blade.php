<!DOCTYPE html>


@extends('admin.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')
        <div class="header">
            
            <div class = "left-column">
            @if(!empty($categories))
                <p>商品カテゴリ編集</p>
            @else
                <p>商品カテゴリ登録</p>
            @endif
            </div>
        
            <div class = "right-column">
                <a class="headerbutton" href="{{  url('/admin/items/category') }}">一覧へ戻る</a>
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
                <form method="post" action="{{ route('admin_items.post') }}">
                <!-- 押したらweb.phpのメンバー登録のrouteに送られる -->

                    @csrf
                    
                    @if(!empty($categories))
                    @foreach ($categories as $category)
                    <div class="element_wrap">
                        <label for="id">商品大カテゴリID</label>
                        <p>{{$category->id}}</p> 
                    </div>

                    <div class="element_wrap">
                        <label for="category_name">商品大カテゴリ</label>              
                        <input type="text" name="category_name" value="@if(old('category_name')){{ old('category_name') }} @elseif($category->category_name){{$category->category_name}} @endif" />
                    </div>

                    <div class="element_wrap">
                        <label for="subcategory_name">商品小カテゴリ</label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        
                    </div>

                    @endforeach
                @else
                    <div class="element_wrap">
                        <label for="id">商品大カテゴリID</label>
                        <p>登録後に自動採番</p> 
                    </div>

                    <div class="element_wrap">
                        <label for="category_name">商品大カテゴリ</label>              
                        <input type="text" name="category_name" value="{{ old('category_name') }}" />
                    </div>

                    <div class="element_wrap">
                        <label for="subcategory_name">商品小カテゴリ</label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name" value="{{ old('subcategory_name') }}" />
                        
                    </div>

                    @endif

                    <input type="submit" name="btn_confirm" value="確認画面へ" />
                    
                </form>
        </div>
@endsection