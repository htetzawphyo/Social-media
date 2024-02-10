<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function() {
    Route::controller(PostController::class)->group(function() {
        Route::get('/', 'index')->name('index');
        Route::get('/post', 'ownPost')->name('post.own');
        Route::get('/post/add', 'add')->name('post.add');
        Route::post('/post/store', 'store')->name('post.store');
        Route::get('/post/detail/{post}', 'detail')->name('post.detail');
        Route::get('/post/edit/{post}', 'edit')->name('post.edit');
        Route::put('/post/update/{post}', 'update')->name('post.update');
        Route::delete('/post/delete/{post}', 'delete')->name('post.delete');
    });

    Route::controller(CommentController::class)->group(function() {
        Route::get('/comment/{comment}', 'show')->name('comment.show');
        Route::post('/comment/create', 'create')->name('comment.create');
        Route::patch('/comment/update/{comment}', 'update')->name('comment.update');
        Route::delete('/comment/delete/{comment}', 'delete')->name('comment.delete');
    });
});
