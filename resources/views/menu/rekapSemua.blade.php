@extends('layouts.index')

@section('content')
    <div class="max-w-4xl mx-auto p-6">
        <div class="mb-8 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Pesanan</h1>
            <a href="/total" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Detail Produk -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Detail Produk</h2>
                <div class="space-y-4">
                    @foreach($keranjangItems as $keranjang)
                        <div class="flex justify-between items-center border-b border-gray-100 pb-4">
                            <div>
                                <p class="font-medium">{{ $keranjang->produk->name }}</p>
                                <p class="text-sm text-gray-500">{{ $keranjang->quantity }} x Rp{{ number_format($keranjang->produk->price, 0, ',', '.') }}</p>
                            </div>
                            <p class="font-medium">Rp{{ number_format($keranjang->produk->price * $keranjang->quantity, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Informasi Pengiriman -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Informasi Pengiriman</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Nama Penerima</p>
                        <p class="font-medium">{{ $pesanan->nama }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium">{{ $pesanan->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Nomor Telepon</p>
                        <p class="font-medium">{{ $pesanan->phone }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kabupaten</p>
                        <p class="font-medium">{{ $pesanan->kabupaten }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Kecamatan</p>
                        <p class="font-medium">{{ $pesanan->kecamatan }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Alamat Lengkap</p>
                        <p class="font-medium">{{ $pesanan->alamat }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-sm text-gray-500">Catatan</p>
                        <p class="font-medium">{{ $pesanan->catatan ?? 'Tidak ada catatan' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="p-6">
                <h2 class="text-lg font-semibold mb-4">Detail Pembayaran</h2>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <p class="text-gray-500">Metode Pembayaran</p>
                        <p class="font-medium">{{ $pesanan->metode_pembayaran }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-gray-500">Subtotal</p>
                        <p class="font-medium">Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-gray-500">Diskon</p>
                        <p class="font-medium text-green-600">-Rp0</p>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-2 mt-2">
                        <p class="font-semibold">Total</p>
                        <p class="font-semibold">Rp{{ number_format($pesanan->subtotal, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center">
            <a href="{{ route('isidata.edit', $pesanan->id) }}" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 font-medium">
                Ubah Pesanan
            </a>    
            <button class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                Konfirmasi & Bayar
            </button>
        </div>
    </div>
@endsection
