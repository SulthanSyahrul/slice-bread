<!-- resources/views/payment.blade.php -->
@extends('layouts.index')

@section('content')
<div class="container mx-auto px-6 py-10">
    <!-- Card Wrapper -->
    <div class="bg-white shadow-xl rounded-lg p-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Payment Details</h2>

        <!-- Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Order Information -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Order Information</h3>
                <ul class="space-y-3">
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Order ID:</span>
                        <span class="text-gray-800 font-semibold">{{ $pesanan->id }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Customer Name:</span>
                        <span class="text-gray-800 font-semibold">{{ $pesanan->nama }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Email:</span>
                        <span class="text-gray-800 font-semibold">{{ $pesanan->email }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Phone:</span>
                        <span class="text-gray-800 font-semibold">{{ $pesanan->phone }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Total Price:</span>
                        <span class="text-green-600 font-bold">{{ number_format($pesanan->total_harga, 2, ',', '.') }}</span>
                    </li>
                    <li class="flex justify-between">
                        <span class="text-gray-600 font-medium">Status:</span>
                        <span class="text-blue-500 font-bold">{{ $pesanan->status }}</span>
                    </li>
                </ul>
            </div>

            <!-- Payment Section -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-md">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Payment</h3>
            
                @if ($pesanan->status === 'success')
                    <p class="text-green-600 mb-6 text-center font-semibold">
                        Pesanan sudah dibayar, terima kasih!
                    </p>
                @elseif ($pesanan->status === 'expired')
                    <p class="text-red-600 mb-6 text-center font-semibold">
                        Pesanan telah kedaluwarsa. Silakan buat pesanan baru.
                    </p>
                @elseif ($pesanan->status === 'cancelled')
                    <p class="text-red-600 mb-6 text-center font-semibold">
                        Pesanan telah dibatalkan.
                    </p>
                @else
                    <p class="text-gray-600 mb-6">
                        Click the button below to proceed with the payment via Midtrans:
                    </p>
                    <div class="flex justify-center">
                        <button id="pay-button" 
                            class="bg-gradient-to-r from-blue-500 to-purple-500 text-white px-6 py-3 rounded-lg shadow-lg hover:opacity-90 transition-all">
                            Pay Now
                        </button>
                    </div>
                    <p class="text-sm text-gray-500 mt-4 text-center">
                        Powered by Midtrans. Secure and reliable payments.
                    </p>
                @endif
            </div>
        </div>
    </div>

    <!-- Add Snap.js for Midtrans -->
    @if(isset($snap_token))
    <script type="text/javascript" 
            src="https://app.sandbox.midtrans.com/snap/snap.js" 
            data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.onclick = function(event) {
            event.preventDefault();
            window.snap.pay('{{ $snap_token }}', {
                onSuccess: function(result) {
                    alert('Payment success!');
                    // Redirect to dashboard after payment success
                    window.location.reload(); 
                },
                onPending: function(result) {
                    alert('Waiting for payment confirmation');
                },
                onError: function(result) {
                    alert('Payment failed!');
                }
            });
        };
    </script>
    @endif
    
</div>
@endsection