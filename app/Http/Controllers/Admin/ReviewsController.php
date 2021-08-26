<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\reviews;
use Validator; //バリデーションを使うから必要
use App\Models\items;
use App\Models\members; //モデルクラス呼び出し
use App\Models\Categories; //モデルクラス呼び出し
use App\Models\SubCategories; //モデルクラス呼び出し
use Illuminate\Support\Facades\DB; //DBクラス
use App\Providers\RouteServiceProvider;

class ReviewsController extends Controller
{
    public function all(Request $request){
         //検索機能
         $review_id = $request->input('review_id');
         $free_word = $request->input('free_word');
 
         if(!empty($review_id) && !empty($free_word)){
             $query = reviews::where('id',$review_id)
             ->where('comment',$free_word);
           
         }elseif(empty($review_id) && !empty($free_word)){
             $query = reviews::where('comment',$free_word);
 
         }elseif(!empty($review_id) && empty($free_word)){
             $query = reviews::where('id',$review_id);
         }else{
             $query = reviews::query();
         }
 
         if(!empty($request->sort)){
             $sort = $request->sort;
             $direction = $request->direction;
         }else{
             $sort = 'id';
             $direction = 'desc';
         }
 
         if($sort == "id" && $direction == "asc"){
             $reviews = $query->orderBy('id', 'asc')->sortable()->paginate(10);
         }elseif($sort == "id" && $direction == "desc"){
             $reviews = $query->orderBy('id', 'desc')->sortable()->paginate(10);
         }elseif($sort == "created_at" && $direction == "asc"){
             $reviews = $query->orderBy('created_at', 'asc')->sortable()->paginate(10);
         }elseif($sort == "created_at" && $direction == "desc"){
             $reviews = $query->orderBy('created_at', 'desc')->sortable()->paginate(10);
         }else{
             $reviews = $query->orderBy($id, 'desc')->sortable()->paginate(10);
         }
             
 
         return view("admin.reviews.all",compact(
             'reviews'
         ));
    }

    public function show(Request $request){
        $id = $request->id;
        $items = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->select('reviews.id as review_id','products.imege_1 as imege_1','products.id as product_id','products.name as name','reviews.evaluation as evaluation','reviews.comment as comment')
                ->get();

        $item =json_decode(json_encode($items), true);

        $evaluation = items::where('products.id',$item[0]["product_id"])
        ->join('reviews','products.id','=','reviews.product_id')
        ->avg('reviews.evaluation');

        return view("admin.reviews.form",compact(
            'items','id','item','evaluation'
        ));
    }

    public function post(Request $request){
        $input = $request->only("comment","evaluation","product_id","review_id");
        $validator = Validator::make($request->all(), [
			"comment" => ['required','string','max:500'],
			"evaluation" => ['required','in:1,2,3,4,5'],
		]);
        if($validator->fails()){
			return redirect()->action("Admin\ReviewsController@show",['id'=>$input["review_id"]])
				->withInput()
				->withErrors($validator);
		}

        $request->session()->put("form_input", $input);

        return redirect()->action("Admin\ReviewsController@confirm",['id'=>$input["review_id"]]);
    }

    public function confirm(Request $request){
        $input = $request->session()->get("form_input");
        $id = $request->id;
        $items = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->select('reviews.id as review_id','products.imege_1 as imege_1','products.id as product_id','products.name as name','reviews.evaluation as evaluation','reviews.comment as comment')
                ->get();
        $item =json_decode(json_encode($items), true);
        $evaluation = items::where('products.id',$item[0]["product_id"])
        ->join('reviews','products.id','=','reviews.product_id')
        ->avg('reviews.evaluation');

        
        if(!$input){
			return redirect()->action("Admin\ReviewsController@show");
		}
		return view("admin.reviews.confirm",compact(
            'items','input','evaluation'
        ));
    }

    public function send(Request $request){
        $input = $request->session()->get("form_input");

        if(!$input){
			return redirect()->action("Admin\ReviewsController@show");
		}

        $reviews = reviews::where('id',$input["review_id"])->first();
        $reviews->evaluation = $input["evaluation"];
        $reviews->comment = $input["comment"];
        $reviews->save();

        //セッションを空にする
		$request->session()->forget("form_input");
        
        return redirect()->action("Admin\ReviewsController@all");
    }

    public function detail(Request $request){

        $id = $request->id;
        $items = reviews::where('reviews.id',$id)
                ->join('products','reviews.product_id','=','products.id')
                ->select('reviews.id as review_id','products.imege_1 as imege_1','products.id as product_id','products.name as name','reviews.evaluation as evaluation','reviews.comment as comment')
                ->get();
        $item =json_decode(json_encode($items), true);
        $evaluation = items::where('products.id',$item[0]["product_id"])
        ->join('reviews','products.id','=','reviews.product_id')
        ->avg('reviews.evaluation');

		return view("admin.reviews.detail",compact(
            'items','evaluation'
        ));
    }

    public function delete_confirm(Request $request)
    {
        //
    }

  public function destroy(Request $request)
    {
        if($request->products_id){
            $product = reviews::find($request->products_id)->delete();
            
            return redirect()->action("Admin\ReviewsController@all");
        }
        
    }

}
