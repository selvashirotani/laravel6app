<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator; //バリデーションを使うから必要
use App\Rules\AlphaNumHalf;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;


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


    public function show(Request $request){
        return view('member.reset');
    }

    public function change(Request $request){
        $input = $request->only("name_sei", "name_mei", "nickname","gender");

        $validator = Validator::make($request->all(), [
			"name_sei" => ['required','string','max:20'],
			"name_mei" => ['required','string','max:20'],
			"nickname" => ['required','string','max:10'],
			"gender" => ['required','in:1,2']
		]);

        if($validator->fails()){
			return redirect()->action("MemberController@show")
				->withInput()
				->withErrors($validator);
		}

        $request->session()->put("form_input", $input);

        return redirect()->action("MemberController@confirm");
    }

    public function confirm(Request $request){
        $input = $request->session()->get("form_input");
        if(!$input){
			return redirect()->action("MemberController@show");
		}
		return view("member.reset_confirm",["input" => $input]);
    }

    public function send(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("MemberController@show");
		}

        $member = User::where('email',$request->email)->first();
        $member->name_sei = $input["name_sei"];
        $member->name_mei = $input["name_mei"];
        $member->nickname = $input["nickname"];
        $member->gender = $input["gender"];
        $member->save();

        //セッションを空にする
		$request->session()->forget("form_input");
        
        return redirect()->action("MemberController@all");
    }


    public function change_pass_confirm(Request $request){
        return view('member.pass_reset');
    }

    public function change_pass(Request $request){

        $validator = Validator::make($request->all(),[
            "password" => ['required',new AlphaNumHalf,'max:20','min:8'],
			//パスワード確認 https://www.kaasan.info/archives/3719
			"password_confirmation" => ["same:password"]
        ]);

        if($validator->fails()){
			return redirect()->action("MemberController@change_pass_confirm")
				->withInput()
				->withErrors($validator);
		}else{
            $password = User::where('email',$request->email)->first();
            $password->password = Hash::make($request->password);
            $password->save();
            return redirect()->action("MemberController@all");;
        }

    }

    public function change_email_confirm(Request $request){     

        return view('member.email_reset');
    }

    public function change_email(Request $request){
        $input = $request->only('email');

        $validator = Validator::make($request->all(), [
			"email" => ['required','email:rfc,dns','max:200','unique:App\Models\members,email,NULL,id,deleted_at,NULL']
		]);

        if($validator->fails()){
			return redirect()->action("MemberController@change_email_confirm")
				->withInput()
				->withErrors($validator);
		}

        $auth_code = mt_rand(100000,999999); 

        $member = User::where('id', $request->member_id)->first();
        $member->auth_code = $auth_code;
        $member->save();

        Mail::send('member.emailreset',["auth_code" => $auth_code],function($message){
            $message->to('a@gmail.com')
                    ->subject('メールアドレス変更の認証コード');
        });

        $request->session()->put("email_input", $input);
        return redirect()->action("MemberController@auth_email_show");

        
    }

    public function auth_email_show(Request $request){
        return view('member.email_auth');
    }

    public function auth_email(Request $request){
        $input = $request->session()->get("email_input");
        if(!$input){
			return redirect()->action("MemberController@change_email");
		}
        $member = User::where('id', $request->member_id)->first();
        if($request->auth_code == $member->auth_code){
            $member->email = $input["email"];
            $member->save();
            //セッションを空にする
		    $request->session()->forget("email_input");
            return redirect()->action("MemberController@all");
        }else{
            return redirect()->action("MemberController@auth_email_show")
				->withInput()
				->withErrors("認証コードが間違っています。");
        }
    }

}
