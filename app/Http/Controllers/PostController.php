<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories; 
use App\Models\SubCategories;

class PostController extends Controller
{
     /**
     * ajaxリクエストを受け取り、サブカテゴリを返す
     */
    public function fetch(Request $request) {
        $product_category_id = $request['product_category_id'];
        $product_sub_category_id = $request['product_sub_category_id'];
        $subCategory = SubCategories::where('parent_category_id', $product_category_id)->get();
        // return view("item.item",compact(
        //     'subCategory ','product_category_id','product_subcategorys'
        // ))
        // ;
        return $subCategory;
    }

}
