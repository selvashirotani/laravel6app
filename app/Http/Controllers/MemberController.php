<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    function show(){

		return view("member.mypage");
        //show()関数は問い合わせフォームを表示
	}

}
