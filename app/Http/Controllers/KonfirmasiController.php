<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiController extends Controller
{
    // Method untuk menampilkan konfirmasi pesanan
    public function index()
    {

        $id_pesanan = session('id_pesanan');

        // Ambil data pesanan berdasarkan ID pelanggan
        $pesanan = Pesanan::where('id', $id_pesanan)->first();
        
        // Ambil data keranjang berdasarkan ID pelanggan
        $keranjangItems = DetailPesanan::where('id_pesanan', $id_pesanan)->with('produk')->get();

        // Kirim data ke view
        return view('menu.rekapsemua', compact('pesanan', 'keranjangItems'));
    }
}

