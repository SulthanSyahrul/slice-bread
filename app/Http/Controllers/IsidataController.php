<?php

namespace App\Http\Controllers;

use App\Helpers\CartManagement;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsidataController extends Controller
{
    public function index()
    {
        // Mengambil item keranjang menggunakan CartManagement
        $keranjangItems = CartManagement::getCartItemsFromCookie();
        $total_harga = CartManagement::calculateGrandTotal($keranjangItems);

        if (empty($keranjangItems)) {
            return redirect('/produk')->withErrors('Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        return view('menu.isiData', compact('keranjangItems','total_harga'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login')->withErrors('Silakan login untuk melanjutkan.');
        }
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'alamat' => 'required|string',
            'catatan' => 'nullable|string',
            'payment_method'=> 'required|string'
        ]);

        // Ambil data keranjang menggunakan CartManagement
        $keranjangItems = CartManagement::getCartItemsFromCookie();

        if (empty($keranjangItems)) {
            return redirect('/produk')->withErrors('Keranjang kosong. Silakan tambahkan produk terlebih dahulu.');
        }

        // Hitung total belanja menggunakan fungsi di CartManagement
        $grandTotal = CartManagement::calculateGrandTotal($keranjangItems);

        // Simpan pesanan ke tabel `pesanan`
        $pesanan = Pesanan::create([
            'id_pelanggan' => Auth::id(),
            'nama' => $validated['nama'],   
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'kabupaten' => $validated['kabupaten'],
            'kecamatan' => $validated['kecamatan'],
            'alamat' => $validated['alamat'],
            'catatan' => $validated['catatan'],
            'total_harga' => $grandTotal,
            'payment_status' => 'pending',
            'payment_method' => $validated['payment_method'],
        ]);

        // Simpan detail pesanan ke tabel `detail_pesanan`
        foreach ($keranjangItems as $item) {
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id,
                'id_produk' => $item['id_produk'],
                'quantity' => $item['quantity'],
                'harga_satuan' => $item['unit_amount'],
                'harga_total' => $item['total_amount'],
            ]);
        }

        // Hapus keranjang setelah pesanan dibuat
        CartManagement::clearCartItemsFromCookie();

        return redirect()->route('konfirmasi', ['id_pesanan' => $pesanan->id])->with('success', 'Pesanan berhasil disimpan.');
    }
}
