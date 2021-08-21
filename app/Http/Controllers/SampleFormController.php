<?php

//アロー演算子( ->)について https://www.flatflag.nir87.com/arrow-249

//2021080222:54
//コントローラー作成

//確認画面を作っていく。
//参照 https://note.com/laravelstudy/n/n1b82595e9fdd

//セッション使う。

// 大きな流れは次のような形です。

// ・フォームからの遷移先でセッションに入力値を保存
// ・確認画面の表示はセッションの入力値を使う
// ・確認画面からの遷移先もセッションの入力値を使う
// ・送信処理（確認画面からの遷移先）で二重投稿にならないようにセッションの値を空にする

namespace App\Http\Controllers; //元から
use Illuminate\Http\Request; //元から バリデーションについて

use Validator; //バリデーションを使うから必要

use App\Models\members; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use Illuminate\Support\Facades\Hash; //ハッシュ化 https://note.com/kakidamediary/n/n9ad1cfbf878b
use App\Rules\AlphaNumHalf;//追記

class SampleFormController extends Controller //この行、元から
{
    //バリデーション

    private $formItems = ["password_confirmation","name_sei", "name_mei", "nickname","gender","password","email"];

	// private $validator = [
	// 	"name_sei" => "required|string|max:20",
    //     "name_mei" => "required|string|max:20",
    //     "nickname" => "required|string|max:10",
	// 	"gender" => "required|in:1,2",
	// 	//2021080309:18 性別のとこでエラー
	// 	"password" => "required|string|max:20|min:8",
	// 	//パスワード確認 https://www.kaasan.info/archives/3719
	// 	"password_confirmation" => "same:password",
    //     "email" => "required|email:rfc,dns|max:200|unique:App\Models\members,email",
    //     // "email" => "必須か|メール形式か|max:200|DB登録済じゃないか"
    //     //データベース内に存在しないかバリデート
    //     //参照 https://readouble.com/laravel/8.x/ja/validation.html#rule-unique
    //     //テーブル名は、App\Models\Member.php 内で指定。
    //     //データベース作ってないからエラーになる可能性大(2021080223:33)
	// 	//案の定エラー
	// 	//"email" => "required|email:rfc,dns|max:200|unique:App\Models\Member,email"
	// ];

    //フォームの表示

	function show(){
		return view("form.form");
        //show()関数は問い合わせフォームを表示
	}

	// 2021080322:36 master.php関連
	// public function add() {
    //     $genders = config('master');
    //     return view('form.form', compact('gender'));
    // }

	function post(Request $request){
		
		$input = $request->only($this->formItems);
		
		//$validator = Validator::make($input, $this->validator);
		
		$validator = Validator::make($request->all(), [
			"name_sei" => ['required','string','max:20'],
			"name_mei" => ['required','string','max:20'],
			"nickname" => ['required','string','max:10'],
			"gender" => ['required','in:1,2'],
			//2021080309:18 性別のとこでエラー
			"password" => ['required',new AlphaNumHalf,'max:20','min:8'],
			//パスワード確認 https://www.kaasan.info/archives/3719
			"password_confirmation" => ["same:password"],
			"email" => ['required','email:rfc,dns','max:200','unique:App\Models\members,email,NULL,id,deleted_at,NULL'],
		]);

		if($validator->fails()){
			return redirect()->action("SampleFormController@show")
				->withInput()
				->withErrors($validator);
		}

		//セッションに書き込む
		$request->session()->put("form_input", $input);
        //form_inputというキーでフォームの入力値を保存

		return redirect()->action("SampleFormController@confirm");
        //confirm()関数のルーティングにリダイレクトします。この書き方で「/form/confirm」にリダイレクトします。
	}

    //確認画面
    function confirm(Request $request){
        //confirm()関数で呼び出されている。

		//セッションから値を取り出す
		$input = $request->session()->get("form_input");
		//先頭を削除 https://uxmilk.jp/8884
		array_shift($input);

		//https://www.php.net/manual/ja/function.array-replace.php
		$replacements2 = array('password' => Hash::make($request->password));
		$input = array_replace($input,$replacements2);
		
		//セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("SampleFormController@show");
		}
		return view("form.form_confirm",["input" => $input]);
        //resources/views/form_confirm.blade.php

    }

    //送信処理
    function send(Request $request){
		//セッションから値を取り出す
		$input = $request->session()->get("form_input");
		// $replacements2 = array('password' => Hash::make($request->password));
		// $input = array_replace($input,$replacements2);

		//セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("SampleFormController@show");
		}

		//ここでメールを送信するなどを行う

		members::all(); //モデルクラス(members.php)で行ったこといれるよ。

		\DB::beginTransaction();
		try{
			//新規登録
			//DB::insert('insert into members(name_sei,name_mei,nickname,gender,password,email) values (:name_sei,:name_mei,:nickname,:gender,:password,:email)',$input);

			//Eloquent https://qiita.com/shosho/items/5ca6bdb880b130260586
			$member = new members;

			$member->name_sei = $input["name_sei"];
			$member->name_mei = $input["name_mei"];
			$member->nickname = $input["nickname"];
			$member->gender = $input["gender"];
			$member->password =  Hash::make($input["password"]);
			$member->email = $input["email"];

			$member->save();
			\DB::commit();
		}catch(\Throwable $e){
			\DB::rollback();
			abort(500); //500エラーを表示する。
		}

		// 二重送信対策(2021080415:51)
		//参考 https://www.bnote.net/blog/laravel_double_submit.html
        $request->session()->regenerateToken();
		
		//セッションを空にする
		$request->session()->forget("form_input");

		return redirect()->action("SampleFormController@complete");
	}

    //完了画面
    function complete(){	
		return view("form.form_complete");
	}
}

//formフォルダ内にform.blade.phpなどいれたので、viewで返す時に"form.form_complete"このようにしてる。
