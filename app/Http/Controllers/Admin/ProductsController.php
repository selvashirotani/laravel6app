<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\items;

class ProductsController extends Controller
{
    private $formItems = ["id","member_id","product_category_id","product_subcategory_id","name","imege_1","imege_2","imege_3","imege_4","product_content","created_at"];

    public function all(Request $request){

        //検索機能
        $products_id = $request->input('products_id');
        $free_word = $request->input('free_word');

        if(!empty($products_id) && !empty($free_word)){
            $query = items::where('id',$products_id)
            ->where(function($query)use($free_word){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word .'%');
            });
          
        }elseif(empty($products_id) && !empty($free_word)){
            $query = items::where(function($query)use($free_word){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word .'%');
            });

        }elseif(!empty($products_id) && empty($free_word)){
            $query = items::query();
                $query->where('id',$products_id);
        }else{
            $query = items::query();
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
            

        return view("admin.products.all",compact(
            'items'
        ));
    }

}
