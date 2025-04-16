<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');  
Route::post('/login-process', [AuthController::class, 'loginProcess'])->name('login-process');  
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');  



Route::middleware(['auth', 'cekrole:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin-dashboard');
    Route::get('/admin/product', [AdminController::class, 'product'])->name('admin-product');
    Route::get('/admin/create-product', [AdminController::class, 'createProduct'])->name('admin-create-product');
    Route::post('/admin/product-store', [AdminController::class, 'productStore'])->name('admin-create-store');
    Route::get('/admin/edit/{id}', [AdminController::class, 'edit'])->name('product.edit');
    Route::put('/admin/update/{id}', [AdminController::class, 'update'])->name('product.update');
    Route::delete('/product/delete/{id}', [AdminController::class, 'destroy'])->name('product.destroy');


    Route::get('/admin/add-penjualan', [AdminController::class, 'addPenjualan'])->name('admin-add-penjualan');
    Route::get('/admin/add-penjualan/create-penjualan', [AdminController::class, 'createPenjualan'])->name('admin-create-penjualan');
    Route::get('/member/verification', [AdminController::class, 'showVerificationForm'])->name('member.verification');
    Route::post('/member/verification', [AdminController::class, 'verifyMember'])->name('member.verify');

});

Route::middleware(['auth', 'cekrole:petugas'])->group(function () {
    Route::get('/petugas/dashboard', [PetugasController::class, 'dashboard'])->name('petugas-dashboard');
});

