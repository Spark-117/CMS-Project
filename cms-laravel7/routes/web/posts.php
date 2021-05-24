<?php


use Illuminate\Support\Facades\Route;


Route::get('/post/{post}', 'PostController@show')->name('post');

Route::middleware(['auth'])->group(function (){

    Route::get('/posts/create', 'PostController@create')->name('post.create');

    Route::get('/posts', 'PostController@index')->name('post.index');

    Route::post('/posts', 'PostController@store')->name('post.store');


    Route::get('/posts/{post}/edit', 'PostController@edit')->name('post.edit');

    Route::delete('/posts/{post}/delete', 'PostController@destroy')->name('post.destroy');

    Route::patch('/posts/{post}/update', 'PostController@update')->name('post.update');

});


