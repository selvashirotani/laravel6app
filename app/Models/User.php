<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Notifications\PasswordResetNotification; //パスワードリセットメールについて？

#論理削除の場所を指示
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    
    #論理削除の利用を宣言
    use SoftDeletes;

    protected $table = 'users';
    protected $dates = ['deleted_at'];


    use Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name_sei','name_mei','nickname','gender','password','email'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

     /**
     * パスワードリセット通知の送信をオーバーライド
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new PasswordResetNotification($token));
    }

}
