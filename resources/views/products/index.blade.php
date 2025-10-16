<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Product Catalog</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        header {
            background: #2c3e50;
            color: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .cart-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .cart-count {
            background: #e74c3c;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.8rem;
            min-width: 20px;
            text-align: center;
        }

        .filter-section {
            background: white;
            padding: 20px 0;
            margin-bottom: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .filter-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-select {
            padding: 8px 15px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
            min-width: 200px;
            cursor: pointer;
        }

        .products-section {
            padding: 20px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 20px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            cursor: pointer;
        }

        .product-image {
            height: 200px;
            background: linear-gradient(45deg, #3498db, #2980b9);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        .product-info {
            padding: 20px;
        }

        .product-name {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #2c3e50;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 10px;
        }

        .product-description {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.4;
        }

        .product-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
            text-align: center;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            background: #3498db;
            color: white;
        }

        .btn-success {
            background: #27ae60;
            color: white;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-success:hover {
            background: #229954;
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn-success:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .btn-link {
            background: transparent;
            color: #3498db;
            padding: 5px 10px;
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 15px;
            }

            .filter-controls {
                justify-content: center;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 15px;
            }

            .product-actions {
                flex-direction: column;
                gap: 8px;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <div class="logo">
                    <a href="{{ route('products.index') }}" style="color: white; text-decoration: none;">
                        E-Commerce Store
                    </a>
                </div>
                <div class="cart-info">
                    <a href="{{ route('products.cart') }}" style="color: white; text-decoration: none;">
                        Keranjang
                        <span class="cart-count" id="cartCount">
                            {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="filter-section">
            <div class="container">
                <div class="filter-controls">
                    <label for="categoryFilter"><strong>Filter berdasarkan kategori:</strong></label>
                    <select id="categoryFilter" class="filter-select" onchange="filterProducts()">
                        <option value="all" {{ !$selectedCategory || $selectedCategory == 'all' ? 'selected' : '' }}>
                            Semua Kategori
                        </option>
                        @foreach($categories as $key => $name)
                            <option value="{{ $key }}" {{ $selectedCategory == $key ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <section class="products-section">
            <div class="container">
                <h1>Katalog Produk</h1>
                
                @if(count($products) > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                            <div class="product-card">
                                <div class="product-image">
                                    
                                </div>
                                <div class="product-info">
                                    <h3 class="product-name">{{ $product['name'] }}</h3>
                                    <p class="product-description">{{ $product['description'] }}</p>
                                    <div class="product-price">
                                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                                    </div>
                                    <div class="product-actions">
                                        <input type="number" value="1" min="1" max="10" 
                                               class="quantity-input" id="qty-{{ $product['id'] }}">
                                        <button class="btn btn-success" 
                                                onclick="addToCart({{ $product['id'] }})">
                                            Tambah ke Keranjang
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div style="text-align: center; padding: 50px;">
                        <h3>Tidak ada produk ditemukan</h3>
                        <p>Coba ubah filter kategori atau kembali ke semua kategori.</p>
                    </div>
                @endif
            </div>
        </section>
    </main>

    <script>

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function filterProducts() {
            const category = document.getElementById('categoryFilter').value;
            const url = new URL(window.location);
            
            if (category === 'all') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }
            
            window.location.href = url.toString();
        }

        // Add product to cart
        function addToCart(productId) {
            const quantity = document.getElementById(`qty-${productId}`).value;
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(quantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cartCount').textContent = data.cart_count;
                    
                    document.getElementById(`qty-${productId}`).value = 1;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        `                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
        // Update cart count on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cartCount').textContent = data.count;
                })
                .catch(error => console.error('Error fetching cart count:', error));
        });
    </script>
</body>
</html>