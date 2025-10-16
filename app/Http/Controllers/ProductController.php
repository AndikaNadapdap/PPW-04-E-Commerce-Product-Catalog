<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Data produk sederhana (dalam aplikasi nyata bisa dari database)
    private $products = [
        [
            'id' => 1,
            'name' => 'Laptop Gaming ROG',
            'price' => 15000000,
            'description' => 'Laptop gaming dengan spesifikasi tinggi untuk gaming dan multimedia',
            'category' => 'electronics',
            'image' => 'laptop-rog.jpg'
        ],
        [
            'id' => 2,
            'name' => 'Smartphone Samsung Galaxy',
            'price' => 8000000,
            'description' => 'Smartphone Android dengan kamera berkualitas tinggi',
            'category' => 'electronics',
            'image' => 'samsung-galaxy.jpg'
        ],
        [
            'id' => 3,
            'name' => 'Kemeja Casual Pria',
            'price' => 250000,
            'description' => 'Kemeja casual berkualitas tinggi untuk pria',
            'category' => 'clothing',
            'image' => 'kemeja-pria.jpg'
        ],
        [
            'id' => 4,
            'name' => 'Dress Wanita Elegant',
            'price' => 350000,
            'description' => 'Dress elegant untuk acara formal dan kasual',
            'category' => 'clothing',
            'image' => 'dress-wanita.jpg'
        ],
        [
            'id' => 5,
            'name' => 'Sepatu Sneakers Nike',
            'price' => 1200000,
            'description' => 'Sepatu sneakers Nike original untuk olahraga dan kasual',
            'category' => 'shoes',
            'image' => 'nike-sneakers.jpg'
        ],
        [
            'id' => 6,
            'name' => 'Tas Backpack Outdoor',
            'price' => 450000,
            'description' => 'Tas backpack tahan air untuk aktivitas outdoor',
            'category' => 'accessories',
            'image' => 'backpack-outdoor.jpg'
        ]
    ];

    private $categories = [
        'electronics' => 'Elektronik',
        'clothing' => 'Pakaian',
        'shoes' => 'Sepatu',
        'accessories' => 'Aksesoris'
    ];

    /**
     * Halaman utama produk dengan fitur filter
     */
    public function index(Request $request)
    {
        $products = $this->products;
        $categories = $this->categories;
        $selectedCategory = $request->get('category');

        // Filter produk berdasarkan kategori jika ada
        if ($selectedCategory && $selectedCategory !== 'all') {
            $products = array_filter($products, function($product) use ($selectedCategory) {
                return $product['category'] === $selectedCategory;
            });
        }

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Detail produk
     */
    public function show($id)
    {
        $product = collect($this->products)->firstWhere('id', $id);
        
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('products.show', compact('product'));
    }

    /**
     * Menambahkan produk ke keranjang
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        // Cari produk
        $product = collect($this->products)->firstWhere('id', $productId);
        
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
     * Tampilkan keranjang belanja
     */
    public function cart()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('products.cart', compact('cart', 'total'));
    }

    /**
     * Update quantity di keranjang
     */
    public function updateCart(Request $request)
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
    public function removeFromCart(Request $request)
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
     * Halaman checkout
     */
    public function checkout()
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
    public function processCheckout(Request $request)
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

        return redirect()->route('products.order-success');
    }

    /**
     * Halaman konfirmasi order berhasil
     */
    public function orderSuccess()
    {
        $order = session()->get('last_order');
        
        if (!$order) {
            return redirect()->route('products.index');
        }

        return view('products.order-success', compact('order'));
    }

    /**
     * API untuk mendapatkan jumlah item di cart
     */
    public function getCartCount()
    {
        $cart = session()->get('cart', []);
        $count = array_sum(array_column($cart, 'quantity'));

        return response()->json(['count' => $count]);
    }
}