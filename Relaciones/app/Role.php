<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
use App\User;

class Role extends Model
{
    protected $fillable = ['role'];

    //muchos a traves de 
    public function posts()
    {
        return $this->hasManyThrough(Post::class,User::class,'role_id','user_id','id','id');
    }
}
