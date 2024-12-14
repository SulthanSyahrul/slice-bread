<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiController extends Controller
{
    // Method untuk menampilkan konfirmasi pesanan
    public function index($id_pesanan)
    {
        // Ambil data pesanan berdasarkan ID pesanan yang dikirimkan melalui URL
        $pesanan = Pesanan::where('id', $id_pesanan)->first();
        
        // Jika pesanan tidak ditemukan, berikan respons error
        if (!$pesanan) {
            return redirect('/')->with('error', 'Pesanan tidak ditemukan.');
        }
    
        // Ambil data detail pesanan berdasarkan ID pesanan
        $keranjangItems = DetailPesanan::where('id_pesanan', $id_pesanan)->with('produk')->get();
    
        // Kirim data ke view
        return view('menu.rekapsemua', compact('pesanan', 'keranjangItems'));
    }
    
}

