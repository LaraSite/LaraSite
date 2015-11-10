<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth.basic'], function() {
    Route::resource('articles', 'ArticlesController', ['except' => ['show', 'destroy']]);
    Route::delete('articles', ['as' => 'admin.articles.destroy', 'uses' => 'ArticlesController@destroy']);

    Route::resource('categories', 'CategoriesController', ['only' => ['index', 'store']]);
    Route::delete('categories', ['as' => 'admin.categories.destroy', 'uses' => 'CategoriesController@destroy']);

    Route::resource('tags', 'TagsController', ['only' => ['index', 'store']]);
    Route::delete('tags', ['as' => 'admin.tags.destroy', 'uses' => 'TagsController@destroy']);

    Route::resource('upload_files', 'UploadFilesController', ['only' => ['index', 'store']]);
    Route::delete('upload_files', ['as' => 'admin.upload_files.destroy', 'uses' => 'UploadFilesController@destroy']);

    Route::get('/', function () {
        return redirect('/admin/articles');
    });
});
