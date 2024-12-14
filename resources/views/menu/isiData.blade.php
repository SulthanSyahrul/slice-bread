@extends('layouts.index')

@Section('content')
    <form class="flex flex-col lg:flex-row p-10 gap-10 needs-validation" novalidate action="/isidata" method="POST">
        @csrf
        <div class="lg:w-2/3" id="accordion-multiple" data-accordion="open">
            <div class="mb-6">
                <h2 id="accordion-collapse-heading-1">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 rounded-t-lg focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 accordion-header"
                        data-accordion-target="#accordion-body-1" aria-expanded="false">
                        <span class="flex items-center text-xl font-bold text-x-black">
                            <span class="mr-2">1.</span>
                            Alamat Pengiriman
                        </span>
                        <svg class="w-3 h-3 transition-transform duration-200" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700 rounded-b-lg accordion-content hidden"
                    id="accordion-body-1">
                    <div class="space-y-4">
                        <div>
                            <label for="Nama"
                                class="block mb-2 text-base font-medium text-gray-900 dark:text-white">Nama
                                Lengkap</label>
                            <input type="text" id="nama" name="nama"
                                class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Nama Lengkap..." required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="email" class="block mb-2 text-base font-medium text-gray-900">Email</label>
                                <input type="email" id="email" name="email"
                                    class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Email..." required />
                            </div>
                            <div>
                                <label for="phone" class="block mb-2 text-base font-medium text-gray-900">Nomor
                                    Handphone</label>
                                <input type="tel" id="phone" name="phone"
                                    class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="No Hp..." required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="kabupaten"
                                    class="block mb-2 text-base font-medium text-gray-900">Kab/kota</label>
                                <select id="kabupaten" name="kabupaten"
                                    class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kab/Kota</option>
                                    <option value="Sragen">Sragen</option>
                                    <option value="Karanganyar">Karangayar</option>
                                    <option value="Surakarta">Surakarta</option>
                                    <option value="Boyolali">Boyolali</option>
                                    <option value="Sukoharjo">Sukoharjo</option>
                                    <option value="Purwodadi">Purwodadi</option>
                                </select>
                            </div>
                            <div>
                                <label for="kecamatan"
                                    class="block mb-2 text-base font-medium text-gray-900">Kecamatan</label>
                                <select id="kecamatan" name="kecamatan"
                                    class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Pilih Kecamatan</option>
                                    <option value="US">Sragen</option>
                                    <option value="CA">Karangayar</option>
                                    <option value="FR">Surakarta</option>
                                    <option value="DE">Boyolali</option>
                                    <option value="DE">Sukoharjo</option>
                                    <option value="DE">Purwodadi</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="alamat" class="block mb-2 text-base font-medium text-gray-900">Alamat
                                Lengkap</label>
                            <input type="text" id="alamat" name="alamat"
                                class="w-full h-14 border border-gray-300 rounded-lg px-4 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Alamat lengkap.." required />
                        </div>

                        <div>
                            <label for="catatan" class="block mb-2 text-base font-medium text-gray-900">Catatan
                                Produk</label>
                            <textarea id="catatan" name="catatan"
                                class="w-full h-32 border border-gray-300 rounded-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Pesan..." required></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!--PAYMENT-->
            <div class="mb-6">
                <h2 id="accordion-collapse-heading-2">
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 rounded-t-lg focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                        data-accordion-target="#accordion-collapse-body-2" aria-expanded="false"
                        aria-controls="accordion-collapse-body-2">
                        <span class="flex items-center text-xl font-bold text-x-black">
                            <span class="mr-2">2.</span>
                            Metode Pembayaran
                        </span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5 5 1 1 5" />
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" class="hidden" aria-labelledby="accordion-collapse-heading-2">
                    <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
                        <div class="space-y-4">
                            <div class="flex items-center ps-4 border border-gray-200 rounded-lg">
                                <input id="bank-transfer" type="radio" value="bank-transfer" name="payment_method"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="bank-transfer" class="w-full py-4 ms-2 text-sm font-medium text-gray-900">Bank
                                    Transfer</label>
                            </div>

                            <div class="flex items-center ps-4 border border-gray-200 rounded-lg">
                                <input id="e-wallet" type="radio" value="e-wallet" name="payment_method"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="e-wallet" class="w-full py-4 ms-2 text-sm font-medium text-gray-900">E-Wallet
                                    (OVO, GoPay,
                                    DANA)</label>
                            </div>

                            <div class="flex items-center ps-4 border border-gray-200 rounded-lg">
                                <input id="cod" type="radio" value="cod" name="payment_method"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="cod" class="w-full py-4 ms-2 text-sm font-medium text-gray-900">Cash on
                                    Delivery (COD)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:w-1/3">
            <div
                class="sticky top-5 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Summary</h3>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <dl class="flex items-center justify-between gap-4">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Total Keranjang</dt>
                            <dd class="text-base font-medium text-gray-900 dark:text-white">
                                Rp{{ number_format($total_harga, 0, ',', '.') }}
                            </dd>
                        </dl>

                        <dl class="flex items-center justify-between gap-4">
                            <dt class="text-base font-normal text-gray-500 dark:text-gray-400">Diskon</dt>
                            <dd class="text-base font-medium text-green-600">Rp0</dd>
                        </dl>
                    </div>

                    <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-4 dark:border-gray-700">
                        <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                        <dd class="text-base font-bold text-gray-900 dark:text-white">
                            Rp{{ number_format($total_harga, 0, ',', '.') }}
                        </dd>
                    </dl>

                    <input type="hidden" name="total_harga" value="{{ $total_harga }}">

                    <button href="/konfimasi" type="submit"
                        class="w-full h-14 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:focus:ring-blue-800 focus:outline-none mt-4 flex items-center justify-center">
                        Konfirmasi Pesanan
                    </button>
                </div>
            </div>
        </div>
    </form>
    @if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses',
            text: '{{ session('success') }}',
        });
    </script>
@endif
@if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 text-red-600 rounded-lg">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@endsection