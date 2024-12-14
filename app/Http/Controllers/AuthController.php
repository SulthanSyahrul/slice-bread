<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Rules\Captcha;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            if (!Auth::user()->email_verified_at) {
                Alert::error('Error', 'Email Anda belum diverifikasi. Silakan periksa email Anda.');
                return redirect()->route('verification.notice');
            }
    
            // Regenerasi sesi dan simpan ID pelanggan
            $request->session()->regenerate();
            $request->session()->put('pelanggan_id', Auth::id());
    
            Alert::success('Success', 'Login berhasil!');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Login gagal! Email atau password salah.');
            return redirect('/login')->withErrors(['email' => 'Email atau password salah.']);
        }
    }
    

    public function process(Request $request)
    {
        // Periksa apakah username dan email sudah ada
        $existingUser = Pelanggan::where('name', $request->name)
            ->orWhere('email', $request->email)
            ->first();
    
        if ($existingUser) {
            Alert::error('Error', 'Username atau email sudah terdaftar.');
            return back()->withInput();
        }
    
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:pelanggan',
            'password' => 'required',
            'confirm-password' => 'required|same:password',
            'g-recaptcha-response' => new Captcha(),
        ]);
    
        $user = Pelanggan::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
    
        // Kirim email verifikasi
        $user->sendEmailVerificationNotification();
    
        Auth::logout();
        Alert::success('Success', 'Registrasi berhasil! Silakan cek email untuk verifikasi.');
    
        // Arahkan ke halaman verifikasi email
        return redirect()->route('verification.notice');
    }
    

    // Metode baru untuk verifikasi email
    public function verifyEmail(Request $request)
    {
        $user = Pelanggan::find($request->route('id'));

        if (!$user) {
            Alert::error('Error', 'Pengguna tidak ditemukan.');
            return redirect('/login');
        }

        if ($user->hasVerifiedEmail()) {
            Alert::info('Info', 'Email sudah terverifikasi.');
            return redirect('/login');
        }

        if ($user->markEmailAsVerified()) {
            Alert::success('Success', 'Email berhasil diverifikasi. Anda dapat login sekarang.');
        } else {
            Alert::error('Error', 'Verifikasi email gagal.');
        }

        return redirect('/login');
    }

    // Metode lainnya tetap sama
    public function register()
    {
        return view('auth.register', [
            'title' => 'Register',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        Alert::success('Success', 'Logout berhasil!');
        return redirect('/login');
    }

    public function reset()
    {
        return view('auth.reset', [
            'title' => 'Reset Password',
        ]);
    }
}