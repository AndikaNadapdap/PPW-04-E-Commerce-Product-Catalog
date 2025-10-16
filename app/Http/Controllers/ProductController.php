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

