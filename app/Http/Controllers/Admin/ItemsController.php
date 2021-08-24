<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\items; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し

class ItemsController extends Controller
{
    public function category(Request $request){

        //検索機能
        $category_id = $request->input('category_id');
        $free_word = $request->input('free_word');

        if(!empty($category_id) && !empty($free_word)){
            $query = Categories::where('id',$category_id)
            ->where(function($query)use($free_word){
                $query->where('category_name','like','%'.$free_word .'%')
                        ->orWhereHas('product_subcategories',function($query)use($free_word){
                            $query->where('subcategory_name','like','%'.$free_word .'%');
                        });
            });
          
        }elseif(empty($category_id) && !empty($free_word)){
            $query = Categories::where('category_name','like','%'.$free_word .'%')
                ->orWhereHas('product_subcategories',function($query)use($free_word){
                    $query->where('subcategory_name','like','%'.$free_word .'%');
                });

        }elseif(!empty($category_id) && empty($free_word)){
            $query = Categories::query();
                $query->where('id',$category_id);
        }else{
            $query = Categories::query();
        }

        if(!empty($request->sort)){
            $sort = $request->sort;
            $direction = $request->direction;
        }else{
            $sort = 'id';
            $direction = 'desc';
        }

        if($sort == "id" && $direction == "asc"){
            $items = $query->orderBy('id', 'asc')->sortable()->paginate(10);
        }elseif($sort == "id" && $direction == "desc"){
            $items = $query->orderBy('id', 'desc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "asc"){
            $items = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
        }elseif($sort == "created_at" && $direction == "desc"){
            $items = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
        }else{
            $items = $query->orderBy($id, 'desc')->sortable()->paginate(10);
        }
            

        return view("admin.items.category",compact(
            'items'
        ));
    }

    public function show(Request $request){
        if(!empty($request->id)){
            $id = $request->id;
            $categories = Categories::where('id',$id)
                    ->get();
            return view("admin.items.form",compact(
                'categories'
            ));

        }else{
            return view("admin.items.form");
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
}
