<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TestQueueEmails;
use Illuminate\Support\Facades\Auth;
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

Route::get('/',[App\Http\Controllers\HomeController::class,'index']);

Route::get('/shop',[\App\Http\Controllers\ShopController::class,'index'])->name('shop');
Route::get('/detail/{id}',[App\Http\Controllers\Detailcontroller::class,'index'])->name('website.detail');
Route::get('/contact', function () {
    return view('website.contact');
});
Route::get('/checkout', function () {
    return view('website.checkout');
});
Route::get('/cart',[\App\Http\Controllers\CartController::class,'index'])->name('website.cart')->middleware('auth');


Auth::routes();

Route::get('/{$localize}', [App\Http\Controllers\LocalizationController::class, 'index']);

Route::group(['prefix' => 'admin', 'middleware' => ['admin']],function () {
    Route::get('/users', [App\Http\Controllers\AdminUserController::class, 'index']);
    Route::post('/users', [App\Http\Controllers\AdminUserController::class, 'index'])->name('search_user');
    Route::get('/users/create', [App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.users.create');
    Route::get('/users/edit/{id}', [App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.users.edit');
    Route::get('/users/delete/{id}', [App\Http\Controllers\AdminUserController::class, 'delete'])->name('admin.users.edit');
    Route::get('/test', [App\Http\Controllers\AdminUserController::class, 'testNotfication']);
    Route::post('/users/create', [App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.create');
    Route::post('/users/update', [App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.users.edit');
});

Route::get('sending-queue-emails', [App\Http\Controllers\AdminUserController::class, 'testNotification'])->name('sending-queue-emails');
Route::get('/zarinpal', [App\Http\Controllers\CheckOutController::class, 'test']);
Route::get('/callback', [App\Http\Controllers\CheckOutController::class, 'callback'])->name('callback');

Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');


#Detail
Route::post('add_to_cart', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('add_to_cart')->middleware('auth');
Route::post('remove_from_cart', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('remove_from_cart')->middleware('auth');

