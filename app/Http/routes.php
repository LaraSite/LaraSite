<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Entities\Article;

require 'routes_admin.php';

Route::get('/blog', function() {
    $articles = Article::with(['category', 'tags'])
      ->where('status', 'Published')
      ->orderBy('published_at', 'desc')
      ->orderBy('created_at', 'desc')
      ->paginate();

    return view('pages.blog.index', compact('articles'));
});

Route::get('/blog/{id}', function($id) {
    $article = Article::findOrFail($id);
    return view('pages.blog.show', compact('article'));
});

Route::post('mailform', 'MailFormController@sendmail');

Route::get('/', function () {
    return view('pages/home');
});

Route::get('{any}', function ($any) {
    try {
        return view("pages/{$any}");
    } catch (Exception $e){
        abort(404);
    }
})->where('view', '.*');
