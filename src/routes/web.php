<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

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

Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('auth.login');

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store'])->name('auth.register');

Route::get('/', [ItemController::class,'index'])->name('item.index');
Route::get('/{item_id}', [ItemController::class, 'detail'])->name('item.detail');
Route::get('/search', [ItemController::class, 'search'])->name('search');

Route::prefix('user')->middleware('auth')->group(function () {
    Route::get('/editProfile', [UserController::class, 'edit'])->name('user.editProfile');
    Route::patch('/updateProfile', [UserController::class, 'update'])->name('user.updateProfile');
    Route::post('/saveImage', [UserController::class, 'saveImage'])->name('user.saveImage');
    Route::get('/myPage', [UserController::class, 'myPage'])->name('user.myPage');
});

Route::prefix('items')->middleware('auth')->group(function () {
    Route::post('/{item_id}/comments', [ItemController::class, 'store'])->name('comments.store');
    Route::post('/{item_id}/toggle-favorite', [ItemController::class, 'toggleFavorite'])->name('favorite.toggle');
    Route::get('/image-upload', [ItemController::class, 'showImageUploadForm'])->name('image_upload_form');
    Route::post('/save-image', [ItemController::class, 'saveImageFromUrl'])->name('save_image');
    Route::get('/sell', [ItemController::class, 'sell'])->name('item.sell');
    Route::get('/item/{item_id}/purchase', [ItemController::class, 'showPurchaseForm'])->name('item.purchase');
    Route::post('/item/{item_id}/purchase', [ItemController::class, 'purchase'])->name('item.purchase.post');
});
