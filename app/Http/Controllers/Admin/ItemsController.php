<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\items; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し

class ItemsController extends Controller
{
    public function category(Request $request){

        //検索機能
        $category_id = $request->input('category_id');
        $free_word = $request->input('free_word');

        if(!empty($category_id) && !empty($free_word)){
            $query = Categories::where('id',$category_id)
            ->where(function($query)use($free_word){
                $query->where('category_name','like','%'.$free_word .'%')
                        ->orWhereHas('product_subcategories',function($query)use($free_word){
                            $query->where('subcategory_name','like','%'.$free_word .'%');
                        });
            });
          
        }elseif(empty($category_id) && !empty($free_word)){
            $query = Categories::where('category_name','like','%'.$free_word .'%')
                ->orWhereHas('product_subcategories',function($query)use($free_word){
                    $query->where('subcategory_name','like','%'.$free_word .'%');
                });

        }elseif(!empty($category_id) && empty($free_word)){
            $query = Categories::query();
                $query->where('id',$category_id);
        }else{
            $query = Categories::query();
        }

        if(!empty($request->sort)){
            $sort = $request->sort;
            $direction = $request->direction;
        }else{
            $sort = 'id';
            $direction = 'desc';
        }

        if($sort == "id" && $direction == "asc"){
            $items = $query->orderBy('id', 'asc')->sortable()->paginate(10);
        }elseif($sort == "id" && $direction == "desc"){
            $items = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "asc"){
            $items = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "desc"){
            $items = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
        }else{
            $items = $query->orderBy($id, 'desc')->sortable()->paginate(10);
        }
            

        return view("admin.items.category",compact(
            'items'
        ));
    }
}
