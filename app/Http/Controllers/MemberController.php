<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;


class MemberController extends Controller
{
    function all(Request $request){

		return view("member.mypage");
        //show()関数は問い合わせフォームを表示
	}

    public function delete_confirm(Request $request)
    {
      $id = (int)$request->id;
      return view('member.delete_confirm',compact(
          'id'
      ));
    }

  public function destroy(Request $request)
    {
        if($request->user_id){
            $user = User::find($request->user_id);
            $user->delete();
            return redirect('/');
        }
        
    }

}
