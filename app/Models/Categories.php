<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SubCategories;
class Categories extends Model
{
    //use HasFactory;
    protected $table = 'product_categorys';
    protected $fillable = ['id','name'];

    // リレーション
    public function product_subcatergorys()
    {
        return $this->hasMany(SubCategories::class);
    }
}
