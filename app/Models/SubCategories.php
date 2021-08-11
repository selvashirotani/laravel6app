<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
class SubCategories extends Model
{
    //use HasFactory;
    protected $table = 'product_subcategories';
    protected $fillable = ['id','parent_category_id','subcategory_name'];

    // public function product_categorys() {
    //     return $this->belongsTo('App\Models\Categories', 'product_category_id', 'id');
    // }
}
