<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\PostController;
use App\Http\Controllers\User\TimelineController;
use App\Http\Controllers\User\UploadController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('auth')->group(function() {
    Route::get('/', [LoginController::class, 'index'])->name('auth.login.index');

    Route::post('login', [LoginController::class, 'store'])->name('auth.login.store');
    Route::post('register', [RegisterController::class, 'store'])->name('auth.register.store');

    Route::post('logout', [LoginController::class, 'logout'])->name('auth.logout.index');
});

Route::prefix('my')->middleware('auth')->group(function() {
    Route::get('/', [TimelineController::class, 'index'])->name('main.timeline.index');
    Route::get('view/{post_id}', [TimelineController::class, 'view'])->name('main.timeline.view');

    Route::get('upload', [UploadController::class, 'index'])->name('main.upload.index');
    Route::post('upload', [UploadController::class, 'store'])->name('main.upload.store');

    Route::post('/get_posts', [TimelineController::class, 'getPosts'])->name('main.timeline.get_posts');
    Route::post('/get_uploaded_status', [TimelineController::class, 'getUploadedStatus'])->name('main.timeline.get_uploaded_status');
});
