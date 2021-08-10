<?php
// 20210804 00:42
// 参照 https://codelikes.com/laravel-eloquent-basic/
//データベースとの接続系 https://note.com/laravelstudy/n/n5111159a572a

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class members extends Model
{
    //use HasFactory;

    protected $table = "users";
    protected $fillable = ['name_sei','name_mei','nickname','gender','password','email'];

    // function create() {
        
        // members::create([
        //     'name_sei' => input('name_sei'),
        //     'name_mei' => input('name_mei'),
        //     'nickname' => input('nickname'),
        //     'gender' => input('gender'),
        //     'password' => input('password'),
        //     'email' => input('email'),
        // ]);
    // }

    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    // ];
}


