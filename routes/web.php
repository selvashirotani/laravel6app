<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// ・get 問い合わせフォームを表示
Route::get('/form', "SampleFormController@show")->name("form.show");
// ・post 問い合わせフォーム遷移先
Route::post('/form', "SampleFormController@post")->name("form.post");

// ・get 確認画面
Route::get('/form/confirm', "SampleFormController@confirm")->name("form.confirm");
// ・post 確認画面からフォーム遷移先
Route::post('/form/confirm', "SampleFormController@send")->name("form.send");

// ・get 完了画面
Route::get('/form/thanks', "SampleFormController@complete")->name("form.complete");


Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

// item 表示
Route::get('/item', "ItemFormController@show")->name("item.show")->middleware('auth');

// item 遷移先
Route::post('/item', "ItemFormController@post")->name("item.post");

// item 確認画面
Route::get('/item/confirm', "ItemFormController@confirm")->name("item.confirm");
// item 確認画面からフォーム遷移先
Route::post('/item/confirm', "ItemFormController@send")->name("item.send");

//セレクトボックス用
Route::post('/fetch/category', 'PostController@fetch')->name('post.fetch');
//セレクトボックス用
Route::post('/fetch/image', 'PostController@image')->name('post.image');


// item 一覧表示
Route::get('/item/all', "ItemAllController@show")->name("itemall.show");

// item 詳細表示
Route::get('/item/all/detail', "ItemAllController@detail")->name("itemall.detail");

// item レビュー表示
Route::get('/item/all/detail/review', "ItemAllController@review")->name("itemall.review")->middleware('auth');

// item レビュー遷移先
Route::post('/item/all/detail/review', "ItemAllController@post")->name("itemall.post");

// item レビュー確認画面
Route::get('/item/all/detail/review/confirm', "ItemAllController@confirm")->name("itemall.confirm");

// item レビュー確認画面からフォーム遷移先
Route::post('/item/all/detail/review/confirm', "ItemAllController@send")->name("itemall.send");
// item レビュー 完了画面
Route::get('/item/all/detail/review/thanks', "ItemAllController@complete")->name("itemall.complete");

// item レビューすべて
Route::get('/item/all/detail/review_show', "ItemAllController@reviewall")->name("itemall.reviewall");


// マイページ詳細
Route::get('/member/detail', "MemberController@all")->name("member.all")->middleware('auth');

//退会画面
Route::get('/member/detail/delete','MemberController@delete_confirm')->name('member.delete_confirm'); //警告画面に飛ばしたいため追記
Route::post('/member/detail/delete','MemberController@destroy')->name("member.destroy"); //destroyを追記

//会員情報変更
Route::get('/member/detail/change','MemberController@show')->name('member.show');
Route::post('/member/detail/change','MemberController@change')->name("member.change");
Route::get('/member/detail/change/confirm','MemberController@confirm')->name('member.confirm');
Route::post('/member/detail/change/confirm','MemberController@send')->name("member.send");

//パスワード変更
Route::get('/member/detail/change_pass','MemberController@change_pass_confirm')->name('member.change_pass_confirm');
Route::post('/member/detail/change_pass','MemberController@change_pass')->name("member.change_pass");

//メールアドレス変更
Route::get('/member/detail/change_email','MemberController@change_email_confirm')->name('member.change_email_confirm');
Route::post('/member/detail/change_email','MemberController@change_email')->name("member.change_email");

//メールアドレス変更の認証
Route::get('/member/detail/auth_email','MemberController@auth_email_show')->name('member.auth_email_show');
Route::post('/member/detail/auth_email','MemberController@auth_email')->name("member.auth_email");

//レビュー関連
Route::get('/member/detail/review','MemberReviewController@all')->name('review.all');
Route::get('/member/detail/review/edit','MemberReviewController@show')->name("review.show");
Route::post('/member/detail/review/edit','MemberReviewController@edit')->name("review.edit");
Route::get('/member/detail/review/edit/confirm','MemberReviewController@confirm')->name("review.confirm");
Route::post('/member/detail/review/edit/confirm','MemberReviewController@send')->name("review.send");

//レビュー削除
Route::get('/member/detail/review/edit/delete','MemberReviewController@view')->name("review.view");
Route::post('/member/detail/review/edit/delete','MemberReviewController@delete')->name("review.delete");

//管理画面
Route::get('/admin/login','Admin\AdminLoginController@form')->name("admin.form");
Route::post('/admin/login','Admin\AdminLoginController@login')->name("admin.login");
Route::get('/admin','Admin\AdminLoginController@view')->name("admin.view");

//管理画面会員一覧
Route::get('/admin/members','Admin\MemberController@all')->name("admin_member.all");
Route::get('/admin/form','Admin\MemberController@show')->name("admin_member.show");
Route::post('/admin/form','Admin\MemberController@post')->name("admin_member.post");
Route::get('/admin/confirm','Admin\MemberController@confirm')->name("admin_member.confirm");
Route::post('/admin/confirm','Admin\MemberController@send')->name("admin_member.send");

//ユーザー詳細
Route::get('/admin/members/detail','Admin\MemberController@detail')->name("admin_member.detail");
//退会画面
Route::get('/admin/members/delete','Admin\MemberController@delete_confirm')->name('admin_member.delete_confirm'); //警告画面に飛ばしたいため追記
Route::post('/admin/members/delete','Admin\MemberController@destroy')->name("admin_member.destroy"); //destroyを追記

//カテゴリ系
Route::get('/admin/items/category','Admin\ItemsController@category')->name("admin_items.category");
Route::get('/admin/items/form','Admin\ItemsController@show')->name("admin_items.show");
Route::post('/admin/items/form','Admin\ItemsController@post')->name("admin_items.post");
Route::get('/admin/items/confirm','Admin\ItemsController@confirm')->name("admin_items.confirm");
Route::post('/admin/items/confirm','Admin\ItemsController@send')->name("admin_items.send");

Route::get('/admin/items/detail','Admin\ItemsController@detail')->name("admin_items.detail");

//カテゴリ削除
Route::get('/admin/items/delete','Admin\ItemsController@delete_confirm')->name('admin_items.delete_confirm'); //警告画面に飛ばしたいため追記
Route::post('/admin/items/delete','Admin\ItemsController@destroy')->name("admin_items.destroy"); //destroyを追記


//アイテム系
Route::get('/admin/products/all','Admin\ProductsController@all')->name("admin_products.all");
Route::get('/admin/products/form','Admin\ProductsController@show')->name("admin_products.show");
Route::post('/admin/products/form','Admin\ProductsController@post')->name("admin_products.post");
Route::get('/admin/products/confirm','Admin\ProductsController@confirm')->name("admin_products.confirm");
Route::post('/admin/products/confirm','Admin\ProductsController@send')->name("admin_products.send");

Route::get('/admin/products/detail','Admin\ProductsController@detail')->name("admin_products.detail");

//カテゴリ削除
Route::get('/admin/products/delete','Admin\ProductsController@delete_confirm')->name('admin_products.delete_confirm'); //警告画面に飛ばしたいため追記
Route::post('/admin/products/delete','Admin\ProductsController@destroy')->name("admin_products.destroy"); //destroyを追記