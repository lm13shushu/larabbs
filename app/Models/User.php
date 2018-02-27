<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{
    // 默认的 User 模型中使用了 trait —— Notifiable，它包含着一个可以用来发通知的方法 notify() ，此方法接收一个通知实例做参数
    use Notifiable{
        notify as protected laravelNotify;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //$fillable 属性的作用是防止用户随意修改模型数据，只有在此属性里定义的字段，才允许修改，否则忽略。
    protected $fillable = [
        'name', 'email', 'password','avatar','introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

     public function topics()
    {
        return $this->hasMany(Topic::class);
    }

    public function isAuthorOf($model)
    {
        return $this->id == $model->user_id;
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }
    //对notify方法进行定制，重写notify方法
     public function notify($instance)
    {
        // 如果要通知的人是当前用户，就不必通知了！
        if ($this->id == Auth::id()) {
            return;
        }
        $this->increment('notification_count');
        //调用自带通知
        $this->laravelNotify($instance);
    }

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
    }
}
