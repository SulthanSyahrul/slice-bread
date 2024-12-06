<?php
namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // Menyiapkan konfigurasi Midtrans
    public function __construct()
    {
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    // Membuat transaksi ke Midtrans dan mendapatkan token pembayaran
public function createSnapToken($id_pesanan)
{
    // Ambil data pesanan dari database
    $pesanan = Pesanan::findOrFail($id_pesanan);

    // Data transaksi Midtrans
    $transaction_details = [
        'order_id' => 'ORDER-' . $pesanan->id . time(),
        'gross_amount' => $pesanan->total_harga, // Total harga
    ];

    // Informasi pelanggan
    $customer_details = [
        'first_name'    => $pesanan->nama,
        'email'         => $pesanan->email,
        'phone'         => $pesanan->phone,
    ];

    // Item yang dibeli
    $items = [];
    foreach ($pesanan->items as $detail) {
        $items[] = [
            'id'       => 'ITEM-' . $detail->id_produk,
            'price'    => $detail->harga_satuan,
            'quantity' => $detail->quantity,
            'name'     => $detail->produk->name,
        ];
    }

    // Membuat transaksi
    $midtrans_transaction = [
        'transaction_details' => $transaction_details,
        'customer_details'    => $customer_details,
        'item_details'        => $items,
    ];

    try {
        // Mendapatkan snap token dari Midtrans
        $snap_token = Snap::getSnapToken($midtrans_transaction);

        // Logging Snap Token untuk debugging
        Log::info('Snap Token generated successfully', ['order_id' => $transaction_details['order_id'], 'snap_token' => $snap_token]);

        // Redirect ke halaman Midtrans dengan token untuk pembayaran
        return view('payment', compact('pesanan', 'snap_token'));
    } catch (\Exception $e) {
        // Logging error jika terjadi kesalahan
        Log::error('Error creating Snap Token', ['error_message' => $e->getMessage(), 'order_id' => $transaction_details['order_id']]);

        // Jika ada error
        return redirect()->back()->withErrors('Terjadi kesalahan saat membuat transaksi: ' . $e->getMessage());
    }
}


    // Menangani notifikasi pembayaran dari Midtrans
    public function handleNotification(Request $request)
    {
        $notification = new Notification();
    
        $status = $notification->transaction_status;
        $order_id = $notification->order_id;
    
        // Ambil pesanan dari database berdasarkan order_id
        $pesanan = Pesanan::where('id', substr($order_id, 6))->first();
    
        if (!$pesanan) {
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }
    
        // Cek status pembayaran dan update status pesanan
        switch ($status) {
            case 'capture':
                // Pembayaran berhasil
                $pesanan->status = 'paid'; // Update status menjadi paid
                break;
            case 'settlement':
                // Pembayaran berhasil dan sudah dikonfirmasi
                $pesanan->status = 'paid'; // Update status menjadi paid
    
                // Update stok produk
                foreach ($pesanan->items as $detail) {
                    $produk = $detail->produk;
                    $produk->stock -= $detail->quantity; // Kurangi stok berdasarkan jumlah produk yang dibeli
                    $produk->save();
                }
    
                break;
            case 'pending':
                // Pembayaran masih menunggu
                $pesanan->status = 'pending';
                break;
            case 'cancel':
                // Pembayaran dibatalkan
                $pesanan->status = 'canceled';
                break;
        }
    
        $pesanan->save();
    
        return response()->json(['status' => 'success']);
    }
    
}
