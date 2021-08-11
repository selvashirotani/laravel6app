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
        $cateVal = $request['category_val'];
        $subCategory = SubCategories::where('parent_category_id', $cateVal)->get();
        return $subCategory;
    }
}
