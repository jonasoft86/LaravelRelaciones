<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coment extends Model
{
    protected $fillable = ['content'];

    public function commentable()
    {
        //Se puede transforma tanto a un modelo de post o videos
        return $this->morphTo();
    }
}
