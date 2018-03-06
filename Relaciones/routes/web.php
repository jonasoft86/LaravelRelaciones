<?php


Route::get('/', function () {
    return view('welcome');
});

use App\User;
use App\Profile;
use App\Post;
use App\Role;
use App\Portfolio;


/* Relacion Uno-Uno */
Route::get('/create_user',function()
{
    $user = User::create([
        'name' => 'jonathan',
        'email'=> 'jonathan@live.com',
        'password' => bcrypt('123456')
    ]);

    return $user;
});

Route::get('/create_profile',function()
{
    $profile = Profile::create([
        'user_id' => 1,
        'phone'=> '74471853',
        'address' => 'Cunco 9081'
    ]);

    return $profile;
});

Route::get('/create_user_profile',function()
{
    $user = User::find(2);

    $profile = new Profile([
        'phone'=> '7447341853',
        'address' => 'Cunco 9000'
    ]);
    $user->profile()->save($profile);
    
    return $user;
});

Route::get('/read_user',function()
{
    $user = User::find(1);

    $data = [
        'name' => $user->name,
        'phone'=> $user->profile->phone,
        'address' => $user->profile->address
    ];
    return $data;
});

Route::get('/read_profile',function()
{
    $profile = Profile::where('phone','74471853')->first();

    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone'=> $profile->phone,
        'address' => $profile->address
    ];
    return $data;
});

Route::get('/update_profile',function()
{
    $user = User::find(1);

    $data = [
        'phone' => '07777777',
        'address' => 'Santiago 1924',
    ];

    $user->profile()->update($data);

    return $user;
});

Route::get('/delete_profile',function()
{
    $user = User::find(1);
    $user->profile()->delete();

    return $user;
});

/* Relacion Uno-Varios */
Route::get('/create_post',function()
{
    $user = User::findOrFail(1);

    $user->posts()->create([
        'title' => 'News of Admin',
        'body'=> 'Noticias'
    ]);

    return 'Success';
});

Route::get('/read_post',function()
{
    $user = User::find(1);

    $posts = $user->posts()->get();

    foreach($posts as $post)
    {
        $data[] = [
            'name' => $post->user->name,
            'post_id' => $post->id,
            'title' => $post->title,
            'body'=> $post->body
        ];
    }

    return $data;
});

Route::get('/update_post',function()
{
    $user = User::findOrFail(1);

    $user->posts()->where('id',2)->update([
        'title' => 'Ultimo Momento post update',
        'body'=> 'Ultimo Momento post update'
    ]);
    
    return 'Success';
});

Route::get('/delete_post',function()
{
    $user = User::find(1);
    $user->posts()->where('id',2)->delete();
    
    return 'Success';
});

/* Relacion Muchos-a-Muchos */
Route::get('/create_categories',function()
{
    /*
    $post = Post::findOrFail(1);

    $post->categories()->create([
        'slug' => str_slug('Tutorial Laravel','-'),
        'category'=> 'Tutorial Laravel'
    ]);
    */
    $user = User::create([
        'name' => 'camilo',
        'email'=> 'camilo@live.com',
        'password' => bcrypt('123456')
    ]);

    $user->posts()->create([
        'title' => 'New Title',
        'body'=> 'New Content'
    ])->categories()->create([
        'slug' => str_slug('New Category','-'),
        'category'=> 'New Category'
    ]);

    return 'Success';
});

Route::get('/read_categories',function()
{
    $post = Post::find(1);
    $categories = $post->categories()->get();

    //dd($categories->get());

    foreach($categories as $category)
    {
        echo $category->slug .'</br>';
    }
});

/*Attach */
Route::get('/attach',function()
{
    $post = Post::find(1);
    //$post->categories()->attach(1);
    $post->categories()->attach([1,2,3]);

    return 'Success';
});

/*Detaching*/
Route::get('/detach',function()
{
    $post = Post::find(1);
    $post->categories()->detach(1);
    //$post->categories()->detach([1,2,3]);
    //$post->categories()->detach();

    return 'Success';
});

/*Syncing 
Evita la duplicidad dejando solo el id que se especifica*/
Route::get('/sync',function()
{
    $post = Post::find(1);
    $post->categories()->sync([3]);

    return 'Success';
});

/*
*Tiene muchos a través
*/
Route::get('/role/posts',function()
{
    $role = Role::find(1);

    return $role->posts;
});

/*
* Polymorphic
*/

Route::get('/comment/create',function()
{
    /*
    $post = Post::find(1);
    $post->comments()->create([
        'user_id'=> 2, 'content' => 'Nuevo contenidos Noticia user 2'
    ]);
    */
    $portfolio = Portfolio::find(2);
    $portfolio->comments()->create([
        'user_id'=> 2, 'content' => 'Nuevo contenidos portafolio user 1'
    ]);

    return 'Success';
});

Route::get('/comment/read',function()
{
    $post = Post::findOrFail(1);
    $comments = $post->comments;

    return $comments;
});