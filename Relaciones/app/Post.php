<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\Comment;

class Post extends Model
{
    protected $fillable = [
        'user_id','title','body'
    ];

    //Relacion Uno-Varios Post
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Relacion Varios-Varios 
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable');
    }
}
