<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\items; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し
use App\Models\reviews;

use Illuminate\Pagination\Paginator;

use Validator; //バリデーションを使うから必要
use App\Models\members; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use Auth;




class ItemAllController extends Controller
{

    //バリデーション
    private $formItems = ["evaluation","comment"];
    private $validator = [
        "evaluation" => "required|in:1,2,3,4,5",
        "comment" => "required|string|max:500",    
    ];


    function show(Request $request){

        //カテゴリ(追加)
        $category = Categories::pluck('category_name','id');
        $subcategory = SubCategories::pluck('subcategory_name','id');

        //検索機能
        //$request->input()で検索時に入力した項目を取得します。
        $search_category = $request->input('product_category_id');
        $search_sub_category = $request->input('product_subcategory_id');
        $free_word  = $request->input('free_word');

        //$query = items::orderBy('id', 'desc')->get();

        // プルダウンメニューで選択した場合、一致するカラムを取得します
        //カテゴリもフリー ワードもある場合
        if(!empty($search_category)&& !empty($free_word )){
            $query = items::where('product_category_id',$search_category)
                            ->where(function($query)use($free_word){
                                $query->where('name','like','%'.$free_word .'%')
                                        ->orWhere('product_content','like','%'.$free_word.'%');
                            });
        }elseif(!empty($search_category) &&!empty($search_category) && !empty($free_word )){
            $query = items::where('product_category_id',$search_category)
                            ->where('product_subcategory_id',$search_sub_category)
                            ->where(function($query)use($free_word){
                                $query->orWhere('name','like','%'.$free_word .'%')
                                        ->orWhere('product_content','like','%'.$free_word.'%');
                            });

        }else{

            //query作成
            $query = items::query();

            if(!empty($search_category)){
                $query->where('product_category_id',$search_category);
            }
    
            if(!empty($search_sub_category)){
                $query->where('product_subcategory_id',$search_sub_category);
            }
    
            //フリー ワード検索
            if(!empty($free_word )){
                $query->where('name','like','%'.$free_word .'%')
                        ->orWhere('product_content','like','%'.$free_word.'%');
            }
        }
 

        //1ページにつき10件ずつ表示
        $items = $query->orderBy('id', 'desc')->paginate(10);
       
        return view('item.item_all',compact(
            'items','category','subcategory'
        ));
    }

    public function detail(Request $request){
        $number = $request->number;
        $query = items::query();
        $query->where('id',$number);
        $items = $query->get();

        $evaluation = items::where('products.id',$number)
                    ->join('reviews','products.id','=','reviews.product_id')
                    ->avg('reviews.evaluation');

        return view('item.item_all_detail',compact(
            'items','number','evaluation'
        ));
    }

    public function review(Request $request){
        if(!empty($input["product_id"])){
            $number = $input["product_id"];
        }else{
            $number = $request->number;
        }
        $query = items::query();
        $query->where('id',$number);
        $items = $query->get();

        $evaluation = items::where('products.id',$number)
                    ->join('reviews','products.id','=','reviews.product_id')
                    ->avg('reviews.evaluation');

        return view('item.item_all_detail_review',compact(
            'items','number','evaluation'
        ));
    }

    public function post(Request $request){

        $input = $request->only("product_id","evaluation","comment");
        $query = items::query();
        $query->where('id',$input["product_id"]);
        $items = $query->get();

        $validator = Validator::make($input, $this->validator);
		if($validator->fails()){
			return back()
				->withInput()
				->withErrors($validator);
		}
        $request->session()->put("item_input", $input);
        return redirect()->action("ItemAllController@confirm");
    }

    public function confirm(Request $request){
        //セッションから値を取り出す
        $input = $request->session()->get("item_input");

        $query = items::query();
        $query->where('id',$input["product_id"]);
        $items = $query->get();
        
        $replacements1 = array('comment' =>nl2br($input['comment']));
        $replacements2 = array('evaluation' => (int)$input['evaluation']);
        $input = array_replace($input,$replacements1,$replacements2);

        $evaluation = items::where('products.id',$input["product_id"])
                    ->join('reviews','products.id','=','reviews.product_id')
                    ->avg('reviews.evaluation');

        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("ItemAllController@review");
		}

        return view("item.item_review_confirm",compact(
            'input','items','evaluation'
        ));
    }

    public function send(Request $request){
        //セッションから値を取り出す
        $input = $request->session()->get("item_input");

        //セッションに値が無い時はフォームに戻る
		if(!$input){
			return redirect()->action("ItemAllController@review");
		}

        reviews::all();

        \DB::beginTransaction();
        try{
            $review = new reviews;
            $review->member_id = Auth::user()->id;
            $review->product_id = $input["product_id"]; //DBからとりだす。
            $review->evaluation = $input["evaluation"];
            $review->comment = $input["comment"];
            
            $review->save();
            \DB::commit();
        }catch(\Throwable $e){
            \DB::rollback();
            abort(500); //500エラーを表示する。
        }

        // 二重送信対策(2021080415:51)
        $request->session()->regenerateToken();

        return redirect()->action("ItemAllController@complete")
                        ->withInput();

    }

    public function complete(Request $request){
        $input = $request->session()->get("item_input");

        return view("item.item_review_complete",compact(
            'input'
        ));

        //セッションを空にする
		$request->session()->forget("item_input");

    }

    public function reviewall(Request $request){

        $number = $request->number;

        // $query = items::query();
        // $query->where('id',$number);
        // $items = $query->get();
        $items = items::where('id',$number)
                    ->get();

        $evaluation = items::where('products.id',$number)
                    ->join('reviews','products.id','=','reviews.product_id')
                    ->avg('reviews.evaluation');

        $comment = reviews::query();
        $comment->where('product_id',$number)
                    ->join('users','reviews.member_id','=','users.id');


        //1ページにつき5件ずつ表示
        $reviews = $comment->orderBy('reviews.id', 'desc')->paginate(5);

        return view("item.item_all_review",compact(
            'items','number','reviews','evaluation'
        ));
    }
}
