<!DOCTYPE html>
<html :class="" x-data="data()" lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slice Bread Bakery</title>
    <link rel="stylesheet" href="{{ asset('css/output.css') }}">
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="../../js/init-alpine.js"></script>
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- CAPTCHA -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
</head>

<body>
    @include('sweetalert::alert')
    <div class="flex items-center justify-center min-h-screen gap-10 bg-gray-50 dark:bg-gray-900">
        <div class="font-bold justify-start">
            <span class="text-orange-500 text-8xl">S</span><span class="text-gray-800 text-6xl">lice</span><span
                class="text-orange-500 text-8xl">B</span><span class="text-gray-800 text-6xl">akery</span>
        </div>

        <div
            class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
            <div class="p-6 space-y-4 md:space-y-6 sm:p-8 ">
                <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                    Silahkan Membuat Akun Anda
                </h1>
                <form class="space-y-4 md:space-y-6 needs-validation" novalidate action="/register" method="POST">
                    @csrf
                    <div>
                        <label for="name"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Nama</label>
                        <input type="name" name="name" id="name"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="username" required="">
                    </div>
                    <div>
                        <label for="email"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Masukkan Email</label>
                        <input type="email" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="name@company.com" required="">
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kata
                            Sandi</label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring--600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div>
                        <label for="confirm-password"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tulis Ulang Kata
                            Sandi</label>
                        <input type="password" name="confirm-password" id="confirm-password"
                            placeholder="••••••••"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required="">
                    </div>
                    <div class="mb-3">
                        <div class="g-recaptcha" 
                             data-sitekey="{{ env('CAPTCHA_KEY') }}"
                             data-theme="light">
                        </div>
                        @error('g-recaptcha-response')
                            <span class="text-danger text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Buat
                        Akun</button>
                    <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                        Sudah punya akun? <a href="/login"
                            class="font-medium text-blue-600 hover:underline dark:text-blue-500">Login disini</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
    
</body>

</html>
