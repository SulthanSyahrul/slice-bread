<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slice Bread Bakery</title>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>
    <header class="flex justify-between items-center py-4 top-0 left-0 w-full z-10 bg-white shadow-md">
        <!-- Logo Section -->
        <div class="flex items-center px-20">
            <a href="/" class="flex items-center hover:opacity-80 transition-opacity">
                <span class="font-bold text-[#faa005] text-[30px]">S</span>
                <span class="font-bold text-[30px]">lice</span>
                <span class="font-bold text-[#faa005] text-[30px]">B</span>
                <span class="font-bold text-[30px]">akery</span>
            </a>
        </div>

        <!-- Navigation Section - Pushed to right -->
        <nav class="flex items-center space-x-8 px-20">
            <div class="flex items-center space-x-6">
                <a href="/menu" class="hover:text-[#faa005] {{ request()->is('menu*') ? 'text-[#faa005] font-bold' : '' }}">Menu</a>
                <a href="/cara" class="hover:text-[#faa005] {{ request()->is('cara*') ? 'text-[#faa005] font-bold' : '' }}">Cara Order</a>
                <a href="/riwayat" class="hover:text-[#faa005] {{ request()->is('riwayat*') ? 'text-[#faa005] font-bold' : '' }}">Riwayat</a>
                <a href="/kontak" class="hover:text-[#faa005] {{ request()->is('kontak*') ? 'text-[#faa005] font-bold' : '' }}">Kontak</a>
            </div>

            <label for="cartToggle" class="cursor-pointer mt-2">
                <button onclick="toggleCart()" class="relative">
                    <svg width="30" height="30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M4.5 5H18.2768C19.0446 5 19.526 5.82948 19.1451 6.49614L16.5758 10.9923C16.2198 11.6154 15.5571 12 14.8394 12H8M8 12L6.45625 14.47C6.03997 15.136 6.51881 16 7.30425 16H18M8 12L4.05279 4.10557C3.714 3.428 3.02148 3 2.26393 3H2M8 20C8 20.5523 7.55228 21 7 21C6.44772 21 6 20.5523 6 20C6 19.4477 6.44772 19 7 19C7.55228 19 8 19.4477 8 20ZM18 20C18 20.5523 17.5523 21 17 21C16.4477 21 16 20.5523 16 20C16 19.4477 16.4477 19 17 19C17.5523 19 18 19.4477 18 20Z"
                            stroke="#FFA500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </label>

            @auth
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#FFA500] text-black font-bold px-5 py-2 text-sm rounded-[27px] hover:bg-[#ed7d05]">
                        Logout
                    </button>
                </form>
            @else
                <a href="/login" class="bg-[#FFA500] text-black font-bold px-5 py-2 text-sm rounded-[27px] hover:bg-[#ed7d05]">
                    Login
                </a>
                @endauth
        
             

            <!-- Mobile Menu Button -->
            <ion-icon onclick="onToggleMenu(this)" name="menu" class="text-3xl cursor-pointer md:hidden"></ion-icon>
        </nav>
    </header>

    <div id="cartOverlay" class="fixed inset-0 hidden bg-gray-500 bg-opacity-75 z-10">
        <div class="fixed right-0 w-full max-w-md bg-white h-full shadow-xl z-20">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">Shopping Cart</h2>
                <button onclick="toggleCart()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <ul>
                    @forelse ($keranjangItems as $item)
                        <li class="flex items-center justify-between mb-4">
                            <img src="{{ asset('images/produk/' . $item['image']) }}" alt="Product Image"
                                class="w-16 h-16 object-cover rounded mr-4">
                            <div class="flex-1">
                                <p class="font-medium">{{ $item['name'] }}</p>
                                <p class="text-gray-500">Rp{{ number_format($item['unit_amount'], 0, ',', '.') }}</p>
                                <p class="text-gray-500">Jumlah: {{ $item['quantity'] }}</p>
                                <p class="text-gray-500">Total: Rp{{ number_format($item['total_amount'], 0, ',', '.') }}</p>
                            </div>
                            <form action="{{ route('menu.destroy', $item['id_produk']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-500 hover:text-red-700">Remove</button>
                            </form>
                        </li>
                    @empty
                        <li class="text-center text-gray-500">Keranjang kosong</li>
                    @endforelse
                </ul>
                
                <div class="mt-8">
                    @php
                    @endphp
                    <p class="text-base font-medium">Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</p>
                    <form action="/total" method="GET">
                        <button type="submit" class="mt-4 w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
                            Checkout
                        </button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>    
    </div>    
    </div>

    @yield('content')

    <div id="Kontak" class="bg-[#C08D55] h-[374px] mt-32 flex items-center justify-center ">
        <div class="flex flex-row justify-center gap-8">
            <!-- Brand Section -->
            <div class="space-y-4 mr-5">
                <h2 class="text-3xl font-bold">
                    <span class="text-[#faa005] text-4xl">S</span>lice
                    <span class="text-[#faa005] text-4xl">B</span>akery
                </h2>
                <p class="text-sm">
                    Selamat berbelanja di Slice Bread Bakery.
                </p>
                <div class="flex space-x-2">
                    <input type="email" placeholder="Enter Your Email"
                        class="px-2 py-2 rounded text-gray-800 w-full text-sm" />
                    <button class="bg-green-700 px-3 py-2 rounded hover:bg-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <div class="flex space-x-4">
                    <a href="#" class="text-red-500 hover:text-red-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.312 16.455c-.156.391-.484.766-.899 1.09-.411.324-.872.576-1.369.737-.497.164-1.037.246-1.618.246-.541 0-1.051-.077-1.528-.23-.476-.153-.905-.383-1.288-.693-.383-.31-.689-.687-.92-1.133-.231-.445-.347-.957-.347-1.534 0-.577.116-1.089.347-1.534.231-.445.537-.822.92-1.133.383-.31.812-.54 1.288-.693.477-.153.987-.23 1.528-.23.581 0 1.121.082 1.618.246.497.161.958.413 1.369.737.415.324.743.699.899 1.09.156.391.234.8.234 1.227 0 .427-.078.836-.234 1.227z" />
                        </svg>
                    </a>
                    <a href="#" class="text-blue-400 hover:text-blue-300">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                        </svg>
                    </a>
                    <a href="#" class="text-blue-600 hover:text-blue-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z" />
                        </svg>
                    </a>
                    <a href="#" class="text-pink-500 hover:text-pink-400">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="#" class="text-red-600 hover:text-red-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Contact Section -->
            <div class="space-y-4 mt-4">
                <h3 class="text-xl font-semibold">Contact us</h3>
                <div class="space-y-2">
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Teguhan Lor 07/03 Sragen Wetan, Sragen
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        0857-1384-5218
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        SliceBreadBakery@gmail.com
                    </p>
                    <p class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Sun - Sat / 10:00 AM - 8:00 PM
                    </p>
                </div>
            </div>

            <!-- Links Section -->
            <div class="space-y-4 mt-4">
                <h3 class="text-xl font-semibold">Links</h3>
                <ul class="space-y-2">
                    <li><a href="#" class="hover:text-yellow-200">Home</a></li>
                    <li><a href="#" class="hover:text-yellow-200">Menu</a></li>
                    <li><a href="#" class="hover:text-yellow-200">Cara Order</a></li>
                    <li><a href="#" class="hover:text-yellow-200">Kontak</a></li>
                </ul>
            </div>
        </div>
    </div>
</body>

<script setup lang="ts">
    function toggleCart() {
        const cartOverlay = document.getElementById('cartOverlay');
        if (cartOverlay) {
            cartOverlay.classList.toggle('hidden');
        }
    }
</script>

</html>
