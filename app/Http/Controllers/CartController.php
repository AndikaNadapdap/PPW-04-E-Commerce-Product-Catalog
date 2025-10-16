<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductDataService;

class CartController extends Controller
{
    /**
     * Tampilkan keranjang belanja
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('products.cart', compact('cart', 'total'));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Cari produk menggunakan ProductDataService
        $product = ProductDataService::getProductById($productId);
        
        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        // Ambil cart dari session
        $cart = session()->get('cart', []);

        // Jika produk sudah ada di cart, tambahkan quantity
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Jika produk belum ada, tambahkan ke cart
            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity,
                'image' => $product['image']
            ];
        }

        // Simpan cart ke session
        session()->put('cart', $cart);

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang',
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Update quantity di keranjang
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:0'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;
        $cart = session()->get('cart', []);

        if ($quantity == 0) {
            // Hapus item dari cart jika quantity 0
            unset($cart[$productId]);
        } else {
            // Update quantity
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = $quantity;
            }
        }

        session()->put('cart', $cart);

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return response()->json([
            'success' => true,
            'total' => $total,
            'cart_count' => array_sum(array_column($cart, 'quantity'))
        ]);
    }

    /**
     * Hapus item dari keranjang
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }

    /**
     * API untuk mendapatkan jumlah item di cart
     */
    public function count()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }

    /**
     * Clear seluruh cart
     */
    public function clear()
    {
        session()->forget('cart');
        
        return response()->json([
            'success' => true,
            'message' => 'Keranjang berhasil dikosongkan'
        ]);
    }
}