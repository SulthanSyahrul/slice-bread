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
        'order_id' => $pesanan->id . time(),
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
            'id'       => $detail->id_produk,
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

public function handleNotification(Request $request)
{
    Log::info('Midtrans Notification received', ['payload' => $request->all()]);

    try {
        $notification = new Notification();

        $status = $notification->transaction_status;
        $order_id = $notification->order_id;
        $order_id = substr($order_id, 0, -10); 

        Log::info('Processing order', ['order_id' => $order_id, 'status' => $status]);

        // Ambil pesanan dari database
        $pesanan = Pesanan::where('id', $order_id)->first();

        if (!$pesanan) {
            Log::error('Pesanan tidak ditemukan', ['order_id' => $order_id]);
            return response()->json(['error' => 'Pesanan tidak ditemukan'], 404);
        }

        // Update status pesanan berdasarkan status pembayaran
        switch ($status) {
            case 'capture':
                $pesanan->status = 'success';
                foreach ($pesanan->items as $detail) {
                    $produk = $detail->produk;
                    $produk->stock -= $detail->quantity;
                    $produk->save();
                }
                break;
            case 'settlement':
                $pesanan->status = 'success';
                foreach ($pesanan->items as $detail) {
                    $produk = $detail->produk;
                    $produk->stock -= $detail->quantity;
                    $produk->save();
                }
                break;
            case 'pending':
                $pesanan->status = 'pending';
                break;
            case 'cancel':
                $pesanan->status = 'canceled';
                break;
            case 'expired':
                $pesanan->status = 'expired';
                break;
            }

        $pesanan->save();

        Log::info('Order updated successfully', ['order_id' => $order_id, 'status' => $status]);
        return response()->json(['status' => 'success'], 200);

    } catch (\Exception $e) {
        Log::error('Error processing notification', ['error_message' => $e->getMessage()]);
        return response()->json(['error' => 'Internal server error'], 500);
    }
}

    
}