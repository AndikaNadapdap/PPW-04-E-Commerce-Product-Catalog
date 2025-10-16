<?php

namespace App\Services;

class ProductDataService
{
    /**
     * Get all products data
     */
    public static function getAllProducts()
    {
        return [
            [
                'id' => 1,
                'name' => 'Laptop Gaming ROG',
                'price' => 15000000,
                'description' => 'Laptop gaming dengan spesifikasi tinggi untuk gaming dan multimedia',
                'category' => 'electronics',
                
            ],
            [
                'id' => 2,
                'name' => 'Smartphone Samsung Galaxy',
                'price' => 8000000,
                'description' => 'Smartphone Android dengan kamera berkualitas tinggi',
                'category' => 'electronics',
                
            ],
            [
                'id' => 3,
                'name' => 'Kemeja Casual Pria',
                'price' => 250000,
                'description' => 'Kemeja casual berkualitas tinggi untuk pria',
                'category' => 'clothing',
               
            ],
            [
                'id' => 4,
                'name' => 'Dress Wanita Elegant',
                'price' => 350000,
                'description' => 'Dress elegant untuk acara formal dan kasual',
                'category' => 'clothing',
                
            ]
        ];
    }

    /**
     * Get all categories
     */
    public static function getAllCategories()
    {
        return [
            'electronics' => 'Elektronik',
            'clothing' => 'Pakaian'
        ];
    }

    /**
     * Get products by category
     */
    public static function getProductsByCategory($category)
    {
        $products = self::getAllProducts();
        
        if (!$category || $category === 'all') {
            return $products;
        }

        return array_filter($products, function($product) use ($category) {
            return $product['category'] === $category;
        });
    }

    /**
     * Get single product by ID
     */
    public static function getProductById($id)
    {
        $products = self::getAllProducts();
        return collect($products)->firstWhere('id', $id);
    }

    /**
     * Search products by name or description
     */
    public static function searchProducts($query)
    {
        $products = self::getAllProducts();
        $query = strtolower($query);

        return array_filter($products, function($product) use ($query) {
            return strpos(strtolower($product['name']), $query) !== false ||
                   strpos(strtolower($product['description']), $query) !== false;
        });
    }

    /**
     * Get featured products (first 4 products)
     */
    public static function getFeaturedProducts($limit = 4)
    {
        $products = self::getAllProducts();
        return array_slice($products, 0, $limit);
    }

    /**
     * Get products by price range
     */
    public static function getProductsByPriceRange($minPrice = 0, $maxPrice = PHP_INT_MAX)
    {
        $products = self::getAllProducts();

        return array_filter($products, function($product) use ($minPrice, $maxPrice) {
            return $product['price'] >= $minPrice && $product['price'] <= $maxPrice;
        });
    }
}