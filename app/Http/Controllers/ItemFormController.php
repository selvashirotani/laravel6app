<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator; //バリデーションを使うから必要
use App\Models\items; //モデルクラス呼び出し
use App\Models\members; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use App\Providers\RouteServiceProvider;
use Auth;

class ItemFormController extends Controller
{
    //バリデーション
    private $formItems = ["name","product_category_id", "product_subcategory_id","imege_1","imege_2","imege_3","imege_4","product_content"];
    private $validator = [
        "name" => "required|string|max:100",
        "product_category_id" => "required|string|max:20",
        "product_subcategory_id" => "required|string|max:10",
        "imege_1" => "image|max:10240",
        "imege_2" => "image|max:10240",
        "imege_3" => "image|max:10240",
        "imege_4" => "image|max:10240",
        "product_content" => "required|string|max:500|",        
    ];

    //アイテムフォームの表示
    function show(Request $request){
        //return view("item.item");

        //カテゴリ(追加)
        $product_categorys = Categories::pluck('name','id');
        $product_subcategorys = SubCategories::pluck('name','id');
        return view('item.item',compact(
            'product_categorys','product_subcategorys'
        ));
    }

    function post(Request $request){

        $input = $request->only($this->formItems);

        $validator = Validator::make($input, $this->validator);
		if($validator->fails()){
			return redirect()->action("ItemFormController@show")
				->withInput()
				->withErrors($validator);
		}    
        
        // 画像を受け取る

        if($request->hasFile('imege_4')){
            $upload_image_4 = $request->file('imege_4');
            if($upload_image_4) {
                //アップロードされた画像を保存
                $path_4 = $upload_image_4->store('uploads','public');
                $input_4['imege_4'] = $path_4;  
            }

            $upload_image_3 = $request->file('imege_3');
            if($upload_image_3) {
                //アップロードされた画像を保存
                $path_3 = $upload_image_3->store('uploads','public');
                $input_3['imege_3'] = $path_3;
            }

            $upload_image_2 = $request->file('imege_2');
            if($upload_image_2) {
                //アップロードされた画像を保存
                $path_2 = $upload_image_2->store('uploads','public');
                $input_2['imege_2'] = $path_2;
            }

            $upload_image_1 = $request->file('imege_1');
            if($upload_image_1) {
                //アップロードされた画像を保存
                $path_1 = $upload_image_1->store('uploads','public');
                $input_1['imege_1'] = $path_1;
            }
            $input_5 = $request->except(["imege_1","imege_2","imege_3","imege_4"]);
            $input = $input_1 + $input_2 + $input_3 + $input_4 + $input_5;

        }elseif($request->hasFile('imege_3')){
            $upload_image_3 = $request->file('imege_3');
            if($upload_image_3) {
                //アップロードされた画像を保存
                $path_3 = $upload_image_3->store('uploads','public');
                $input_3['imege_3'] = $path_3;
            }

            $upload_image_2 = $request->file('imege_2');
            if($upload_image_2) {
                //アップロードされた画像を保存
                $path_2 = $upload_image_2->store('uploads','public');
                $input_2['imege_2'] = $path_2;
            }

            $upload_image_1 = $request->file('imege_1');
            if($upload_image_1) {
                //アップロードされた画像を保存
                $path_1 = $upload_image_1->store('uploads','public');
                $input_1['imege_1'] = $path_1;
            }
            $input_5 = $request->except(["imege_1","imege_2","imege_3"]);
            $input = $input_1 + $input_2 + $input_3 + $input_5;

        }elseif($request->hasFile('imege_2')){
            $upload_image_2 = $request->file('imege_2');
            if($upload_image_2) {
                //アップロードされた画像を保存
                $path_2 = $upload_image_2->store('uploads','public');
                $input_2['imege_2'] = $path_2;
            }

            $upload_image_1 = $request->file('imege_1');
            if($upload_image_1) {
                //アップロードされた画像を保存
                $path_1 = $upload_image_1->store('uploads','public');
                $input_1['imege_1'] = $path_1;
            }
            $input_5 = $request->except(["imege_1","imege_2"]);
            $input = $input_1 + $input_2 + $input_5;

        }elseif($request->hasFile('imege_1')){
            $upload_image_1 = $request->file('imege_1');
            if($upload_image_1) {
                //アップロードされた画像を保存
                $path_1 = $upload_image_1->store('uploads','public');
            }
            $input_1['imege_1'] = $path_1;
            $input_5 = $request->except(["imege_1"]);
            $input = $input_1 + $input_5;
    
        }
    
        
        //セッションに書き込む
		$request->session()->put("item_input", $input);

        //item_inputというキーでフォームの入力値を保存

        return redirect()->action("ItemFormController@confirm");
        //confirm()関数のルーティングにリダイレクトします。この書き方で「/item/confirm」にリダイレクトします。
    }

    //確認画面
    function confirm(Request $request){
        //confirm()関数で呼び出されている。
        

        //セッションから値を取り出す
		$input = $request->session()->get("item_input");

        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("ItemFormController@show");
		}

        $product_categorys = DB::select('select * from product_categorys');

        $product_subcategorys = DB::select('select * from product_subcatergorys');

        return view("item.item_confirm",compact(
            // "input" => $input,
            // 'product_categorys' => $product_categorys,
            // 'product_subcategorys' => $product_subcategorys,
            'input','product_categorys','product_subcategorys'
        ));
    }

    //送信処理
    function send(Request $request){
		//セッションから値を取り出す
        $input = $request->session()->get("item_input");

		//セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("ItemFormController@show");
		}

        items::all();//モデルクラス(items.php)で行ったこといれるよ。

        \DB::beginTransaction();
		try{
            $item = new items;

            $item->member_id = Auth::user()->id;
            $item->name = $input["name"];
            $item->product_category_id = $input["product_category_id"];
            $item->product_subcategory_id = $input["product_subcategory_id"];
            if(isset($input["imege_1"])){
                $item->imege_1 = $input["imege_1"];
            }
            if(isset($input["imege_2"])){
                $item->imege_2 = $input["imege_2"];
            }
            if($input["imege_3"]){
                $item->imege_3 = $input["imege_3"];
            }
            if($input["imege_4"]){
                $item->imege_4 = $input["imege_4"];
            }

            $item->product_content = $input["product_content"];

            $item->save();
            \DB::commit();
        }catch(\Throwable $e){
			\DB::rollback();
			abort(500); //500エラーを表示する。
		}

        // 二重送信対策(2021080415:51)
        $request->session()->regenerateToken();

        //セッションを空にする
		$request->session()->forget("item_input");

        return redirect()->action("ItemFormController@complete");

    }

    //完了画面
    function complete(){	
		return view("welcome");
	}
    
}
