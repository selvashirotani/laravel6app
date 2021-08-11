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
        "product_category_id" => "required|in:1,2,3,4,5",
        "product_subcategory_id" => "required|in:1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25",
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

        if($request->hasFile('imege_1')){
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
        $replacements1 = array('product_content' =>nl2br($input['product_content']));
        $input = array_replace($input,$replacements1);

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
            //$item->imege_1 = $input["imege_1"];

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
