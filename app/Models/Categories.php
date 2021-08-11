<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategories;
class Categories extends Model
{
    //use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = ['id','name'];

    // リレーション
    // public function product_subcatergorys()
    // {
    //     return $this->hasMany(SubCategories::class);
    // }

     // 配列の形で、全カテゴリーを返す
     public static function get_category() 
     {
         $all_category = Categories::all();
         $ret_category = array("" => "");
         foreach($all_category as $category){
              $ret_category += array($category->id => $category->category_name);
         }
         return $ret_category;    
     }  

}