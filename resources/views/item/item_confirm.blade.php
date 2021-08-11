<!-- 202108038:24 テンプレートの作成 確認画面 -->

@extends('layout.layout')
<!-- layoutフォルダ中のlayout.blade.php -->

@section('form')

<div class="main">
    {{var_dump($input)}}

	<h1>商品登録確認画面</h1>

    <form method="post" action="{{ route('item.send') }}" onsubmit="return checkNijyuSubmit();">
	@csrf
		<div class="element_wrap">
			<label>商品名</label>
			<p>{{ $input["name"] }}</p>
		</div>

        <div class="element_wrap">
			<label>商品カテゴリ</label>
			<p>
			@if($input["product_category_id"] === "1")
			インテリア
            @elseif($input["product_category_id"] === "2")
            家電
			@elseif($input["product_category_id"] === "3")
			ファッション
			@elseif($input["product_category_id"] === "4")
			美容
			@elseif($input["product_category_id"] === "5")
			本・雑誌
            @endif
			 > 
			@if($input["product_subcategory_id"] == "1")
			収納家具
			@elseif($input["product_subcategory_id"] == "2")
			寝具
			@elseif($input["product_subcategory_id"] == "3")
			ソファ
			@elseif($input["product_subcategory_id"] == "4")
			ベッド
			@elseif($input["product_subcategory_id"] == "5")
			照明
			@elseif($input["product_subcategory_id"] == "6")
			テレビ
			@elseif($input["product_subcategory_id"] == "7")
			掃除機
			@elseif($input["product_subcategory_id"] == "8")
			エアコン
			@elseif($input["product_subcategory_id"] == "9")
			冷蔵庫
			@elseif($input["product_subcategory_id"] == "10")
			レンジ
			@elseif($input["product_subcategory_id"] == "11")
			トップス
			@elseif($input["product_subcategory_id"] == "12")
			ボトム
			@elseif($input["product_subcategory_id"] == "13")
			ワンピース
			@elseif($input["product_subcategory_id"] == "14")
			ファッション小物
			@elseif($input["product_subcategory_id"] == "15")
			ドレス
			@elseif($input["product_subcategory_id"] == "16")
			ネイル
			@elseif($input["product_subcategory_id"] == "17")
			アロマ
			@elseif($input["product_subcategory_id"] == "18")
			スキンケア
			@elseif($input["product_subcategory_id"] == "19")
			香水
			@elseif($input["product_subcategory_id"] == "20")
			メイク
			@elseif($input["product_subcategory_id"] == "21")
			旅行
			@elseif($input["product_subcategory_id"] == "22")
			ホビー
			@elseif($input["product_subcategory_id"] == "23")
			写真集
			@elseif($input["product_subcategory_id"] == "24")
			小説
			@elseif($input["product_subcategory_id"] == "25")
			ライフスタイル
			@endif
			</p>
		</div>

		<div class="element_wrap">
			<label>商品写真</label>
			<!-- @if(!empty($input['imege_1']))
            <p>写真1</p>
			<img src="/storage/{{ $input['imege_1'] }}" style="width:100%;"/>
			@endif
			@if(!empty($input['imege_2']))
            <p>写真2</p>
			<img src="/storage/{{ $input['imege_2'] }}" style="width:100%;"/>
			@endif
			@if(!empty($input['imege_3']))
            <p>写真3</p>
			<img src="/storage/{{ $input['imege_3'] }}" style="width:100%;"/>
			@endif
			@if(!empty($input['imege_4']))
            <p>写真4</p>
			<img src="/storage/{{ $input['imege_4'] }}" style="width:100%;"/>
			@endif -->
			
		</div>

		<div class="element_wrap">
			<label>商品説明</label>
			<p>{!! nl2br($input["product_content"]) !!}</p>
			
		</div>
		
		<button type="button" name="btn_back" onclick=history.back()>前に戻る</button>
		<input type="submit" name="btn_submit" id="btnSubmit" value="商品を登録する">
	</form>
</div>
@endsection