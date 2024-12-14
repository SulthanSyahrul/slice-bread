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
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Tambahkan route verifikasi email
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed'])
    ->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'Tautan verifikasi telah dikirim ulang');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/register', [AuthController::class, 'register']);
Route::post('/register', [AuthController::class, 'process'])->middleware('web');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/reset', [AuthController::class, 'reset']);

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::resource('/menu', ProdukController::class);



Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// Untuk halaman lain yang memerlukan email terverifikasi
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('/keranjang', KeranjangController::class);
    Route::resource('/total', TotalController::class);
    Route::resource('/isidata', IsidataController::class);
    Route::get('/konfirmasi/{id_pesanan}', [KonfirmasiController::class, 'index'])->name('konfirmasi');
});

Route::get('/payment/{id_pesanan}', [PaymentController::class, 'processPayment'])->name('payment.show');
Route::get('/payment/create/{id_pesanan}', [PaymentController::class, 'createSnapToken'])->name('payment.create');
Route::post('/payment/notification', [PaymentController::class, 'handleNotification']);


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