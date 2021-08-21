<?php
// 20210804 00:42
// 参照 https://codelikes.com/laravel-eloquent-basic/
//データベースとの接続系 https://note.com/laravelstudy/n/n5111159a572a

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;


class members extends Model
{
    //use HasFactory;
    use SoftDeletes;
    protected $table = "users";
    protected $fillable = ['name_sei','name_mei','nickname','gender','password','email','deleted_at'];

}


