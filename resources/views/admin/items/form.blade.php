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
                   
                    <div class="element_wrap">
                        <label for="id">商品大カテゴリID</label>
                        <input type="hidden" name="id" value="{{$category[0]["id"]}}">
                        <p>{{$category[0]["id"]}}</p> 
                    </div>

                    <div class="element_wrap">
                        <label for="category_name">商品大カテゴリ</label>              
                        <input type="text" name="category_name" value="@if(old('category_name')){{ old('category_name') }} @elseif($category[0]["category_name"]){{$category[0]["category_name"]}} @endif" />
                    </div>

                    <div class="element_wrap">
                        <label for="subcategory_name">商品小カテゴリ</label>
                        
                        <input type="text" name="subcategory_name_1" value="@if(old('subcategory_name_1')){{ old('subcategory_name_1') }} @elseif(!empty($category[0]["subcategory_name"])){{$category[0]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_2" value="@if(old('subcategory_name_2')){{ old('subcategory_name_2') }} @elseif(!empty($category[1]["subcategory_name"])){{$category[1]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_3" value="@if(old('subcategory_name_3')){{ old('subcategory_name_3') }} @elseif(!empty($category[2]["subcategory_name"])){{$category[2]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_4" value="@if(old('subcategory_name_4')){{ old('subcategory_name_4') }} @elseif(!empty($category[3]["subcategory_name"])){{$category[3]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_5" value="@if(old('subcategory_name_5')){{ old('subcategory_name_5') }} @elseif(!empty($category[4]["subcategory_name"])){{$category[4]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_6" value="@if(old('subcategory_name_6')){{ old('subcategory_name_6') }} @elseif(!empty($category[5]["subcategory_name"])){{$category[5]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_7" value="@if(old('subcategory_name_7')){{ old('subcategory_name_7') }} @elseif(!empty($category[6]["subcategory_name"])){{$category[6]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_8" value="@if(old('subcategory_name_8')){{ old('subcategory_name_8') }} @elseif(!empty($category[7]["subcategory_name"])){{$category[7]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_9" value="@if(old('subcategory_name_9')){{ old('subcategory_name_9') }} @elseif(!empty($category[8]["subcategory_name"])){{$category[8]["subcategory_name"]}} @else @endif" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_10" value="@if(old('subcategory_name_10')){{ old('subcategory_name_10') }} @elseif(!empty($category[9]["subcategory_name"])){{$category[9]["subcategory_name"]}} @else @endif" />
                        
                    </div>

                
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
                        <input type="text" name="subcategory_name_1" value="{{ old('subcategory_name_1') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_2" value="{{ old('subcategory_name_2') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_3" value="{{ old('subcategory_name_3') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_4" value="{{ old('subcategory_name_4') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_5" value="{{ old('subcategory_name_5') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_6" value="{{ old('subcategory_name_6') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_7" value="{{ old('subcategory_name_7') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_8" value="{{ old('subcategory_name_8') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_9" value="{{ old('subcategory_name_9') }}" />
                        </br>
                        <label for="subcategory_name"></label>
                        <input type="text" name="subcategory_name_10" value="{{ old('subcategory_name_10') }}" />
                        
                    </div>

                    @endif

                    <input type="submit" name="btn_confirm" value="確認画面へ" />
                    
                </form>
        </div>
@endsection