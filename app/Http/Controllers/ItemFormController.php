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
    private $formItems = ["name","product_category_id", "product_subcategory_id","product_content"];
    private $validator = [
        "name" => "required|string|max:100",
        "product_category_id" => "required|in:1,2,3,4,5",
        "product_subcategory_id" => "required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25",
        "product_content" => "required|string|max:500|",        
    ];

    //アイテムフォームの表示
    function show(Request $request){
        //return view("item.item");

        //カテゴリ(追加)
        $category = Categories::pluck('category_name','id');
        $subcategory = SubCategories::pluck('subcategory_name','id');
        return view('item.item',compact(
            'category','subcategory'
        ));


    }

    function post(Request $request){

        //画像処理
        if($request->hasFile('imege_4')){

            $input_image_1 = $request->file('imege_1');
            $input_image_2 = $request->file('imege_2');
            $input_image_3 = $request->file('imege_3');
            $input_image_4 = $request->file('imege_4');

            if($input_image_1) {
                //アップロードされた画像を保存する
                $path_image_1 = $input_image_1->store('uploads',"public");
            }
            if($input_image_2) {
                //アップロードされた画像を保存する
                $path_image_2 = $input_image_2->store('uploads',"public");
            }
            if($input_image_3) {
                //アップロードされた画像を保存する
                $path_image_3 = $input_image_3->store('uploads',"public");
            }
            if($input_image_4) {
                //アップロードされた画像を保存する
                $path_image_4 = $input_image_4->store('uploads',"public");
            }

            $request->session()->put("image_input_1", $path_image_1);
            $request->session()->put("image_input_2", $path_image_2);
            $request->session()->put("image_input_3", $path_image_3);
            $request->session()->put("image_input_4", $path_image_4);
        }
        elseif($request->hasFile('imege_3')){

            $input_image_1 = $request->file('imege_1');
            $input_image_2 = $request->file('imege_2');
            $input_image_3 = $request->file('imege_3');

            if($input_image_1) {
                //アップロードされた画像を保存する
                $path_image_1 = $input_image_1->store('uploads',"public");
            }
            if($input_image_2) {
                //アップロードされた画像を保存する
                $path_image_2 = $input_image_2->store('uploads',"public");
            }
            if($input_image_3) {
                //アップロードされた画像を保存する
                $path_image_3 = $input_image_3->store('uploads',"public");
            }

            $request->session()->put("image_input_1", $path_image_1);
            $request->session()->put("image_input_2", $path_image_2);
            $request->session()->put("image_input_3", $path_image_3);
        }
        elseif($request->hasFile('imege_2')){

            $input_image_1 = $request->file('imege_1');
            $input_image_2 = $request->file('imege_2');

            if($input_image_1) {
                //アップロードされた画像を保存する
                $path_image_1 = $input_image_1->store('uploads',"public");
            }
            if($input_image_2) {
                //アップロードされた画像を保存する
                $path_image_2 = $input_image_2->store('uploads',"public");
            }

            $request->session()->put("image_input_1", $path_image_1);
            $request->session()->put("image_input_2", $path_image_2);
        }
        //１つ目
        elseif($request->hasFile('imege_1')){

            $input_image_1 = $request->file('imege_1');

            if($input_image_1) {
                //アップロードされた画像を保存する
                $path_image_1 = $input_image_1->store('uploads',"public");
            }

            $request->session()->put("image_input_1", $path_image_1);
        }
        //ここまで

        $input = $request->only("name","product_category_id", "product_subcategory_id","product_content");     

        $validator = Validator::make($input, $this->validator);
		if($validator->fails()){
			return redirect()->action("ItemFormController@show")
				->withInput()
				->withErrors($validator);
		}
        
        //セッションに書き込む
        //item_inputというキーでフォームの入力値を保存
		$request->session()->put("item_input", $input);


        return redirect()->action("ItemFormController@confirm");
        //confirm()関数のルーティングにリダイレクトします。この書き方で「/item/confirm」にリダイレクトします。
    }



    //確認画面
    function confirm(Request $request){
        //confirm()関数で呼び出されている。

        //セッションから値を取り出す
		$input = $request->session()->get("item_input");
        $replacements1 = array('product_content' =>nl2br($input['product_content']));
        $input = array_replace($input,$replacements1);

        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("ItemFormController@show");
		}

        $path_image_1 = $request->session()->get("image_input_1");
        $path_image_2 = $request->session()->get("image_input_2");
        $path_image_3 = $request->session()->get("image_input_3");
        $path_image_4 = $request->session()->get("image_input_4");


        if($path_image_4 ){
            return view("item.item_confirm",compact(
                'input','path_image_1','path_image_2','path_image_3','path_image_4'
            ));
        }
        elseif($path_image_3 ){
            return view("item.item_confirm",compact(
                'input','path_image_1','path_image_2','path_image_3'
            ));
        }
        elseif($path_image_2 ){
            return view("item.item_confirm",compact(
                'input','path_image_1','path_image_2'
            ));
        }
        elseif($path_image_1 ){
            return view("item.item_confirm",compact(
                'input','path_image_1'
            ));
        }else{
            return view("item.item_confirm",compact(
                'input'
            ));
        }
        
    }

    //送信処理
    function send(Request $request){
		//セッションから値を取り出す
        $input = $request->session()->get("item_input");

        $path_image_1 = $request->session()->get("image_input_1");
        $path_image_2 = $request->session()->get("image_input_2");
        $path_image_3 = $request->session()->get("image_input_3");
        $path_image_4 = $request->session()->get("image_input_4");
        
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
                $item->product_content = $input["product_content"];
                if($path_image_4){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                    $item->imege_3 = $path_image_3;
                    $item->imege_4 = $path_image_4;
                }
                elseif($path_image_3){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                    $item->imege_3 = $path_image_3;
                }
                elseif($path_image_2){
                    $item->imege_1 = $path_image_1;
                    $item->imege_2 = $path_image_2;
                }
                if($path_image_1){
                    $item->imege_1 = $path_image_1;
                }
                
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
        $request->session()->forget("image_input_1");
        $request->session()->forget("image_input_2");
        $request->session()->forget("image_input_3");
        $request->session()->forget("image_input_4");

        return redirect()->action("ItemFormController@complete");

    }

    //完了画面
    function complete(){	
		return view("welcome");
	}
    
}
