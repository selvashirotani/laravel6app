<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\items; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し

use Illuminate\Pagination\Paginator;

class ItemAllController extends Controller
{
    function show(Request $request){

        //カテゴリ(追加)
        $category = Categories::pluck('category_name','id');
        $subcategory = SubCategories::pluck('subcategory_name','id');

        //検索機能
        //$request->input()で検索時に入力した項目を取得します。
        $search_category = $request->input('product_category_id');
        $search_sub_category = $request->input('product_subcategory_id');
        $free_word  = $request->input('free_word');

        //$query = items::orderBy('id', 'desc')->get();

        // プルダウンメニューで選択した場合、一致するカラムを取得します
        //カテゴリもフリー ワードもある場合
        if(!empty($search_category)&& !empty($free_word )){
            $query = items::where('product_category_id',$search_category)
                            ->where(function($query)use($free_word){
                                $query->where('name','like','%'.$free_word .'%')
                                        ->orWhere('product_content','like','%'.$free_word.'%');
                            });
        }elseif(!empty($search_category) &&!empty($search_category) && !empty($free_word )){
            $query = items::where('product_category_id',$search_category)
                            ->where('product_subcategory_id',$search_sub_category)
                            ->where(function($query)use($free_word){
                                $query->orWhere('name','like','%'.$free_word .'%')
                                        ->orWhere('product_content','like','%'.$free_word.'%');
                            });

        }else{

            //query作成
            $query = items::query();

            if(!empty($search_category)){
                $query->where('product_category_id',$search_category);
            }
    
            if(!empty($search_sub_category)){
                $query->where('product_subcategory_id',$search_sub_category);
            }
    
            //フリー ワード検索
            if(!empty($free_word )){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word.'%');
            }
        }


        //1ページにつき10件ずつ表示
        $items = $query->orderBy('id', 'desc')->paginate(3);
       





        return view('item.item_all',compact(
            'items','category','subcategory'
        ));
    }
}
