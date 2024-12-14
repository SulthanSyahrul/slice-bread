@extends('layouts.index')

@section('content')
    <section class="py-4 px-12 relative">
        <div class="w-full max-w-7xl mx-auto px-4 md:px-8">
            <h2 class="font-manrope font-extrabold text-3xl lead-10 text-black mb-9">Riwayat Order</h2>

            <div class="flex sm:flex-col lg:flex-row sm:items-center justify-between">
                <ul class="flex max-sm:flex-col sm:items-center gap-x-14 gap-y-3">
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-indigo-600 transition-all duration-500 hover:text-indigo-600">
                        Semua Order</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Selesai</li>
                    <li
                        class="font-medium text-lg leading-8 cursor-pointer text-black transition-all duration-500 hover:text-indigo-600">
                        Batal</li>
                </ul>
                <div class="mb-3 flex max-sm:flex-col items-center justify-end gap-2 max-lg:mt-5">
                    <div class="flex items-center gap-3 max-md:mt-5">
                        <button
                            class="rounded-full px-7 py-3 bg-white text-gray-900 border border-gray-300 font-semibold text-sm shadow-sm shadow-transparent transition-all duration-500 hover:shadow-gray-200 hover:bg-gray-50 hover:border-gray-400">Lihat
                            Invoice</button>
                        <button
                            class="rounded-full px-7 py-3 bg-indigo-600 shadow-sm shadow-transparent text-white font-semibold text-sm transition-all duration-500 hover:shadow-indigo-400 hover:bg-indigo-700">Beli
                            Lagi</button>

                    </div>
                </div>
            </div>
            <div class="border border-gray-300">
                <div class="main-data p-8 sm:p-14 bg-gray-50 rounded-3xl">
                    <div class="grid grid-cols-8 pb-9">
                        <div class="col-span-8 lg:col-span-4">
                            <p class="font-bold text-lg leading-8 text-gray-600">Produk</p>
                        </div>
                        <div class="col-span-1 max-lg:hidden">
                            <p class="font-bold text-lg leading-8 text-gray-600 ">Harga</p>
                        </div>
                        <div class="col-span-1 max-lg:hidden ">
                            <p class="font-bold text-lg leading-8 text-gray-600">Jumlah</p>
                        </div>
                        <div class="col-span-1 max-lg:hidden ">
                            <p class="font-bold text-lg leading-8 text-gray-600">Status</p>
                        </div>
                        <div class="col-span-1 max-lg:hidden">
                            <p class="font-bold text-lg leading-8 text-gray-500">Metode</p>
                        </div>
                    </div>
                    <div
                        class="box p-3 rounded-3xl bg-gray-100 grid grid-cols-8 mb-7 cursor-pointer transition-all duration-500 hover:bg-indigo-50 max-lg:max-w-xl max-lg:mx-auto">
                        <div class="col-span-8 sm:col-span-4 lg:col-span-1 sm:row-span-4 lg:row-span-1">
                            <img src="{{ asset('../../images/RotiAnggur.jpg') }}" alt="earbuds image"
                                class="max-lg:w-auto w-20 h-20 max-sm:mx-auto rounded-xl object-cover">
                        </div>
                        <div
                            class="ml-[-30px] col-span-8 sm:col-span-4 lg:col-span-3 flex h-full justify-center flex-col max-lg:items-center">
                            <h5 class="font-manrope font-semibold text-2xl leading-9 text-black mb-1 whitespace-nowrap">
                                Roti Anggur</h5>
                        </div>

                        <div class="col-span-8 sm:col-span-4 lg:col-span-1 flex items-center ">
                            <p class="font-semibold text-xl leading-8 text-black">$249.99</p>
                        </div>
                        <div class="col-span-8 ml-2 sm:col-span-4 lg:col-span-1 flex items-center  ">
                            <p class="font-semibold text-xl leading-8 text-center">2</p>
                        </div>
                        <div class="col-span-8 ml-2 sm:col-span-4 lg:col-span-1 flex items-center  ">
                            <p class="font-semibold text-xl leading-8 text-green-600 text-center">Proses</p>
                        </div>
                        <div class="col-span-8 ml-2 sm:col-span-4 lg:col-span-1 flex items-center  ">
                            <p class="font-semibold text-xl leading-8 text-indigo-600 text-center">Gopay</p>
                        </div>
                    </div>
                    <svg class="mt-9 w-full" xmlns="http://www.w3.org/2000/svg" width="1216" height="2"
                        viewBox="0 0 1216 2" fill="none">
                        <path d="M0 1H1216" stroke="#D1D5DB" />
                    </svg>

                    <div class="px-3 md:px-11 flex items-center justify-end max-sm:flex-col-reverse">
                        <p class="font-medium text-xl leading-8 text-black max-sm:py-4"> <span class="text-gray-500">Total
                                Price: </span> &nbsp;$200.00</p>
                    </div>
                </div>
            </div>
    </section>
@endsection
