<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProductDataService;

class ProductController extends Controller
{
    /**
     * Halaman utama produk dengan fitur filter
     */
    public function index(Request $request)
    {
        $categories = ProductDataService::getAllCategories();
        $selectedCategory = $request->get('category');

        // Get products berdasarkan filter
        $products = ProductDataService::getProductsByCategory($selectedCategory);

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    /**
     * Detail produk
     */
    public function show($id)
    {
        $product = ProductDataService::getProductById($id);
        
        if (!$product) {
            abort(404, 'Produk tidak ditemukan');
        }

        return view('products.show', compact('product'));
    }

    /**
     * Search products (AJAX endpoint)
     */
    public function search(Request $request)
    {
        $query = $request->get('q');
        
        if (empty($query)) {
            return response()->json(['products' => []]);
        }

        $products = ProductDataService::searchProducts($query);

        return response()->json([
            'products' => array_values($products),
            'count' => count($products)
        ]);
    }

    /**
     * Get products by price range (AJAX endpoint)
     */
    public function filterByPrice(Request $request)
    {
        $minPrice = $request->get('min_price', 0);
        $maxPrice = $request->get('max_price', PHP_INT_MAX);
        
        $products = ProductDataService::getProductsByPriceRange($minPrice, $maxPrice);

        return response()->json([
            'products' => array_values($products),
            'count' => count($products)
        ]);
    }

    /**
     * Get featured products (for homepage or widgets)
     */
    public function featured()
    {
        $featuredProducts = ProductDataService::getFeaturedProducts(4);
        
        return response()->json([
            'products' => $featuredProducts
        ]);
    }

    /**
     * Get all categories (API endpoint)
     */
    public function categories()
    {
        $categories = ProductDataService::getAllCategories();
        
        return response()->json([
            'categories' => $categories
        ]);
    }
}