<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator; //バリデーションを使うから必要
use Illuminate\Validation\Rule;

use App\Models\members; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use Illuminate\Support\Facades\Hash; //ハッシュ化 https://note.com/kakidamediary/n/n9ad1cfbf878b
use App\Rules\AlphaNumHalf;//追記

class MemberController extends Controller
{
    private $formItems = ["id","password_confirmation","name_sei", "name_mei", "nickname","gender","password","email"];

    public function all(Request $request){

        //検索機能
        $member_id = $request->input('member_id');
        $gender = $request->input('gender');
        $free_word = $request->input('free_word');

        if(!empty($member_id) && !empty($gender) && !empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where('gender',$gender)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });

        }elseif(!empty($member_id) && !empty($gender) && empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where('gender',$gender);
        }elseif(!empty($member_id) && empty($gender) && !empty($free_word)){
            $query = User::where('id',$member_id)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });
        }elseif(empty($member_id) && !empty($gender) && !empty($free_word)){
            $query = User::where('gender',$gender)
                    ->where(function($query)use ($free_word){
                        $query->where('name_sei','like','%'.$free_word .'%')
                    ->orWhere('name_mei','like','%'.$free_word.'%')
                    ->orWhere('email','like','%'.$free_word.'%');
                    });
        }else{
            //query作成
            $query = User::query();

            if(!empty($member_id)){
                $query->where('id',$member_id);
            }

            if(!empty($gender)){
                $query->where('gender',$gender);
            }

            //フリー ワード検索
            if(!empty($free_word)){
                $query->where('name_sei','like','%'.$free_word .'%')
                        ->orWhere('name_mei','like','%'.$free_word.'%')
                        ->orWhere('email','like','%'.$free_word.'%');
            }
        }

        if(!empty($request->sort)){
            $sort = $request->sort;
            $direction = $request->direction;
        }else{
            $sort = 'id';
            $direction = 'desc';
        }

        if($sort == "id" && $direction == "asc"){
            $members = $query->orderBy('id', 'asc')->sortable()->paginate(10);
        }elseif($sort == "id" && $direction == "desc"){
            $members = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "asc"){
            $members = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "desc"){
            $members = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
        }else{
            $members = $query->orderBy($id, 'desc')->sortable()->paginate(10);
        }
        
        return view('admin.members',compact(
            'members'
        ));
    }

    public function show(Request $request){
        if(!empty($request->id)){
            $id = $request->id;
            $members = User::where('id',$id)
                    ->get();
            return view("admin.form.form",compact(
                'members'
            ));

        }else{
            return view("admin.form.form");
        }
       
        
    }

    public function post(Request $request){
        $input = $request->only($this->formItems);
		
		//$validator = Validator::make($input, $this->validator);
		if(empty($input['id'])){
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
                return redirect()->action("Admin\MemberController@show")
                    ->withInput()
                    ->withErrors($validator);
            }

        }elseif(!empty($input['id']) && empty($input['password'])){
            $validator = Validator::make($request->all(), [
                "name_sei" => ['required','string','max:20'],
                "name_mei" => ['required','string','max:20'],
                "nickname" => ['required','string','max:10'],
                "gender" => ['required','in:1,2'],
                "email" => ['required','email:rfc,dns','max:200',Rule::unique('users','email')->whereNull('deleted_at')->whereNot('id',$input['id'])],
            ]);

            if($validator->fails()){
                return redirect()->action("Admin\MemberController@show",['id'=>$input['id']])
                    ->withInput()
                    ->withErrors($validator);
            }

        }elseif(!empty($input['id']) && !empty($input['password'])){
            $validator = Validator::make($request->all(), [
                "name_sei" => ['required','string','max:20'],
                "name_mei" => ['required','string','max:20'],
                "nickname" => ['required','string','max:10'],
                "gender" => ['required','in:1,2'],
                "password" => ['required',new AlphaNumHalf,'max:20','min:8'],
                //パスワード確認 https://www.kaasan.info/archives/3719
                "password_confirmation" => ["same:password"],
                "email" => ['required','email:rfc,dns','max:200',Rule::unique('users','email')->whereNull('deleted_at')->whereNot('id',$input['id'])],
            ]);

            if($validator->fails()){
                return redirect()->action("Admin\MemberController@show",['id'=>$input['id']])
                    ->withInput()
                    ->withErrors($validator);
            }

        }
		
		


		//セッションに書き込む
		$request->session()->put("form_input", $input);
        //form_inputというキーでフォームの入力値を保存

		return redirect()->action("Admin\MemberController@confirm");
        //confirm()関数のルーティングにリダイレクトします。この書き方で「/form/confirm」にリダイレクトします。
    }

    public function confirm(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("Admin\MemberController@show");
		}
		return view("admin.form.form_confirm",["input" => $input]);
        
    }

    public function send(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("Admin\MemberController@show");
		}


        if(empty($input['id'])){
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
        }elseif(!empty($input['id'])){
            $member = members::where('id',$input['id'])->first();
            $member->name_sei = $input["name_sei"];
            $member->name_mei = $input["name_mei"];
            $member->nickname = $input["nickname"];
            $member->gender = $input["gender"];
            $member->password =  Hash::make($input["password"]);
            $member->email = $input["email"];

            $member->save();
        }
        

		// 二重送信対策(2021080415:51)
		//参考 https://www.bnote.net/blog/laravel_double_submit.html
        $request->session()->regenerateToken();
		
		//セッションを空にする
		$request->session()->forget("form_input");

		return redirect()->action("Admin\MemberController@all");

    }

    public function detail(Request $request){
        
        if(!empty($request->id)){
            $id = $request->id;
            $members = User::where('id',$id)
                    ->get();
            return view("admin.detail",compact(
                'members','id'
            ));

        }else{
            return view("admin.detail");
        }
       
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
            return redirect()->action("Admin\MemberController@all");
        }
        
    }

}
