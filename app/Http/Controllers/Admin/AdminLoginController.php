<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Admin;
use Validator;

class AdminLoginController extends Controller
{
    public function form(Request $request){
        if(session('name')){
            session()->forget('name');
        }
        return view('admin.login');
    }

    public function login(Request $request){
        $input = $request->only("login_id","password");

        $validator = Validator::make($request->all(), [
			"login_id" => ['required','string','min:7','max:10'],
			"password" => ['required','string','min:8','max:20'],
		]);

        if($validator->fails()){
			return redirect()->action("Admin\AdminLoginController@form")
				->withInput()
				->withErrors($validator);
		}

        $admin = Admin::where('login_id',$request->login_id)->get();

        if(count($admin)===0){
            return view('admin.login',['login_id' =>'1']);
        }

        if($request->password == $admin[0]->password){
            session(['name'  => $admin[0]->name]);
            return redirect()->action("Admin\AdminLoginController@view");
            
        }else{
            return view('admin.login', ['login_id' => '1']);
        }

        $request->session()->put("form_input", $input);

    }

    public function view(Request $request){
        $data = session('name');
        if(empty($data)){
            return redirect()->action("Admin\AdminLoginController@form");
        }
        return view('admin.home',compact(
            'data'
        ));
    }
}
