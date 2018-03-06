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

Route::get('/', function () 
{
    $post = App\Post::find(1);
    $post->comments()->create(['content'=>'Post numero 2']);

    //$video = App\Video::find(1);
    //$video->comments()->create(['content'=>'Este post no me gusta']);
    //return $video->comments;
});
