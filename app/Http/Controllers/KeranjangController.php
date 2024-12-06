<?php

namespace App\Http\Controllers;

use App\Helpers\CartManagement;
use App\Models\Produk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $cart_items = CartManagement::getCartItemsFromCookie();
        $grand_total = CartManagement::calculateGrandTotal($cart_items);

        return view('layouts.index', compact('cart_items', 'grand_total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_produk' => 'required|exists:produk,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $id_produk = $validated['id_produk'];
        $quantity = $validated['quantity'] ?? 1; // Default ke 1 jika tidak ada input jumlah

        $produk = Produk::find($id_produk);

        if ($quantity > $produk->stock) {
            return redirect()->back()->withErrors("Stok produk tidak mencukupi. Stok tersedia: {$produk->stock}");
        }
        // Tambahkan item ke keranjang melalui CartManagement
        $cart_count = CartManagement::addItemToCartWithQty($id_produk, $quantity);

        return redirect()->back()->with('success', "Produk berhasil ditambahkan ke keranjang. Total item: $cart_count");
    }

    public function update(Request $request, $product_id)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $validated['quantity'];

        $produk = Produk::find($product_id);

        if ($quantity > $produk->stock) {
            return redirect()->back()->withErrors("Stok produk tidak mencukupi. Stok tersedia: {$produk->stock}");
        }
        
        // Perbarui jumlah item di keranjang melalui CartManagement
        CartManagement::addItemToCartWithQty($product_id, $quantity);

        return redirect()->back()->with('success', 'Jumlah produk berhasil diperbarui.');
    }

    public function destroy($product_id)
    {
        CartManagement::removeCartItems($product_id);

        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }

    public function clear()
    {
        CartManagement::clearCartItemsFromCookie();

        return redirect()->back()->with('success', 'Keranjang berhasil dikosongkan.');
    }
}
