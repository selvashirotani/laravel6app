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
        $product_sub = SubCategories::pluck('name','product_category_id');
        
        return $product_sub;
    }
}
