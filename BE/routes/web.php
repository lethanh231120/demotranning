<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\User\LoginUserController;
use App\Http\Controllers\User\CategoryController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\ForgotpasswordController;


Route::group(['prefix' => 'user'], function () {
    Route::get('/', [LoginUserController::class, 'index'])->name('user.home');
    Route::get('/login', [LoginUserController::class, 'login'])->name('user.get.login');
    Route::post('/login', [LoginUserController::class, 'store'])->name('user.post.login');
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', [CategoryController::class, 'index'])->name('user.get.category');
        Route::get('/create', [CategoryController::class, 'create'])->name('user.create.category');
        Route::post('/create', [CategoryController::class, 'store'])->name('user.store.category');
        Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('user.edit.category');
        Route::post('/edit/{id}', [CategoryController::class, 'update'])->name('user.update.category');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('user.category.destroy');
    });
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', [ProductController::class, 'index'])->name('user.get.product');
        Route::get('/create', [ProductController::class, 'create'])->name('user.create.product');
        Route::post('/create', [ProductController::class, 'store'])->name('user.store.product');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('user.edit.product');
        Route::post('/edit/{id}', [ProductController::class, 'update'])->name('user.update.product');
        Route::delete('/{id}', [ProductController::class, 'destroy'])->name('user.product.destroy');
        Route::get('/pdf', [ProductController::class, 'exportPDF'])->name('product.exportPDF');
        Route::get('/csv', [ProductController::class, 'exportCSV'])->name('product.exportCSV');
    });
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index'])->name('user.get.order');
        Route::get('/order-detail/{id}', [OrderController::class, 'orderDetail'])->name('user.get.order-detail');
        Route::get('/export-pdf-order/{id}', [OrderController::class, 'exportPdfOrder'])->name('use.export-pdf-order');
    });
    Route::get('/language/{locale}', [LanguageController::class, 'index'])->name('language.index');
    Route::get('/forget-password', [ForgotpasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
    Route::post('/forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
    Route::get('/send-data', [ForgotPasswordController::class, 'sendData'])->name('send-data');
    Route::get('/recover-password/{email}/{token}', [ForgotPasswordController::class, 'getRecoverPassword'])->name('reset.password.get');
    Route::post('/update-password', [ForgotPasswordController::class, 'updatePassword'])->name('reset.password.post');
});

Route::get('admin/', [AdminController::class, 'index'])->name('home')->middleware('admin');
Route::get('admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('admin/login', [AdminController::class, 'store'])->name('admin.post.login');
Route::get('admin/logout', [AdminController::class, 'destroy']);
Route::middleware('admin')->prefix('admin')->group(function () {
    Route::get('/create', [UserController::class, 'create'])->name('admin.create');
    Route::post('/create', [UserController::class, 'store'])->name('create.user');
    Route::get('edit/{id}', [UserController::class, 'edit'])->name('admin.edit.view');
    Route::post('edit/{id}', [UserController::class, 'update'])->name('edit');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    Route::get('/getProvinces', [UserController::class, 'getProvinces'])->name('getprovinces');
    Route::get('/getDistricts/{id}', [UserController::class, 'getDistricts'])->name('getdistrict');
    Route::get('/getCommunes/{id}', [UserController::class, 'getCommunes'])->name('getcommune');
});
