<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Halaman checkout
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kosong');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('products.checkout', compact('cart', 'total'));
    }

    /**
     * Proses checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kosong');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Simpan data order (dalam aplikasi nyata disimpan ke database)
        $orderData = [
            'order_id' => 'ORD-' . time(),
            'customer' => $request->only(['name', 'email', 'phone', 'address']),
            'items' => $cart,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'order_date' => now()
        ];

        // Simpan ke session untuk ditampilkan di halaman konfirmasi
        session()->put('last_order', $orderData);
        
        // Kosongkan keranjang
        session()->forget('cart');

        return redirect()->route('checkout.success');
    }

    /**
     * Halaman konfirmasi order berhasil
     */
    public function success()
    {
        $order = session()->get('last_order');
        
        if (!$order) {
            return redirect()->route('products.index');
        }

        return view('products.order-success', compact('order'));
    }

    /**
     * Halaman review order sebelum checkout
     */
    public function review()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Keranjang belanja kosong');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $total = $subtotal;

        return view('products.checkout-review', compact(
            'cart', 
            'total'
        ));
    }

    /**
     * Calculate order totals
     */
    public function calculateTotals($cart)
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $total = $subtotal;

        return [
            'subtotal' => $subtotal,
            'total' => $total
        ];
    }

    /**
     * API endpoint untuk mendapatkan kalkulasi total
     */
    public function getTotals()
    {
        $cart = session()->get('cart', []);
        $totals = $this->calculateTotals($cart);

        return response()->json($totals);
    }

    /**
     * Validate checkout form via AJAX
     */
    public function validateForm(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'payment_method' => 'required|string'
        ];

        $validator = validator($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        return response()->json(['success' => true]);
    }
}