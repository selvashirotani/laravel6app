<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Categories;
class SubCategories extends Model
{
    //use HasFactory;
    protected $table = 'product_subcategories';
    protected $fillable = ['subcategory_name','id'];

    // public function product_categorys() {
    //     return $this->belongsTo('App\Models\Categories', 'product_category_id', 'id');
    // }
}
