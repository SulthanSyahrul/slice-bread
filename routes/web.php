<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IsidataController;
use App\Http\Controllers\TotalController;
use App\Http\Controllers\KonfirmasiController;
use App\Http\Controllers\PaymentController;

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process'])->middleware('web');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/reset', [AuthController::class, 'reset']);

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('/menu', ProdukController::class);

Route::resource('/keranjang', KeranjangController::class);

Route::get('/payment/create/{id_pesanan}', [PaymentController::class, 'createSnapToken'])->name('payment.create');
Route::post('/payment/update', [PaymentController::class, 'updateOrder'])->name('payment.update');


Route::resource('/total', TotalController::class);

Route::resource('/isidata', IsidataController::class);

Route::resource('/konfirmasi', KonfirmasiController::class);

Route::get('/cara', function () {
    return view('tampilan.cara');
});
Route::get('/riwayat', function () {
    return view('tampilan.riwayat');
});
Route::get('/kontak', function () {
    return view('tampilan.kontak');
});
Route::get('/reset', function () {
    return view('auth.reset');
});