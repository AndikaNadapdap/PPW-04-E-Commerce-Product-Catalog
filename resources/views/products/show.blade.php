<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product['name'] }} - E-Commerce</title>
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

        .product-detail {
            background: white;
            margin: 30px 0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .product-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            padding: 40px;
        }

        .product-image-section {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .main-image {
            height: 400px;
            background: linear-gradient(135deg, #3498db, #2980b9);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .product-title {
            font-size: 1rem;
            font-weight: bold;
            color: white;
            z-index: 2;
            position: relative;
        }

        .product-info-section {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .breadcrumb {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }

        .product-name {
            font-size: 2.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 2rem;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 20px;
        }

        .product-description {
            color: #34495e;
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .product-meta {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .meta-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .meta-item:last-child {
            margin-bottom: 0;
        }

        .meta-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .meta-value {
            color: #34495e;
        }

        .purchase-section {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            border: 2px solid #ecf0f1;
        }

        .quantity-section {
            margin-bottom: 20px;
        }

        .quantity-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .quantity-btn {
            width: 40px;
            height: 40px;
            border: 2px solid #ddd;
            background: white;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .quantity-input {
            width: 80px;
            text-align: center;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 15px;
            background: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            margin-bottom: 15px;
        }

        .buy-now-btn {
            width: 100%;
            padding: 15px;
            background: #3498db;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: block;
        }

        .back-btn {
            background: white;
            color: #3498db;
            border: 2px solid #3498db;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .product-content {
                grid-template-columns: 1fr;
                gap: 20px;
                padding: 20px;
            }

            .main-image {
                height: 300px;
            }

            .product-name {
                font-size: 1.8rem;
            }

            .product-price {
                font-size: 1.6rem;
            }

            .quantity-controls {
                justify-content: center;
            }

            .header-content {
                flex-direction: column;
                gap: 15px;
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
        <div class="container">
            <a href="{{ route('products.index') }}" class="back-btn">
                ← Kembali ke Katalog
            </a>

            <div class="product-detail">
                <div class="product-content">
                    <div class="product-image-section">
                        <div class="main-image">
                        </div>
                    </div>

                    <div class="product-info-section">
                        <div class="breadcrumb">
                            <a href="{{ route('products.index') }}">Beranda</a> / 
                            <a href="{{ route('products.index') }}?category={{ $product['category'] }}">
                                @switch($product['category'])
                                    @case('electronics') Elektronik @break
                                    @case('clothing') Pakaian @break
                                    @case('shoes') Sepatu @break
                                    @case('accessories') Aksesoris @break
                                    @default {{ ucfirst($product['category']) }}
                                @endswitch
                            </a> / 
                            {{ $product['name'] }}
                        </div>

                        <h1 class="product-name">{{ $product['name'] }}</h1>
                        
                        <div class="product-price">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </div>

                        <p class="product-description">
                            {{ $product['description'] }}
                        </p>

                        <div class="product-meta">
                            <div class="meta-item">
                                <span class="meta-label">Kategori:</span>
                                <span class="meta-value">
                                    @switch($product['category'])
                                        @case('electronics') Elektronik @break
                                        @case('clothing') Pakaian @break
                                        @case('shoes') Sepatu @break
                                        @case('accessories') Aksesoris @break
                                        @default {{ ucfirst($product['category']) }}
                                    @endswitch
                                </span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">SKU:</span>
                                <span class="meta-value">PRD-{{ str_pad($product['id'], 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Status:</span>
                                <span class="meta-value" style="color: #27ae60; font-weight: bold;">✓ Tersedia</span>
                            </div>
                            <div class="meta-item">
                                <span class="meta-label">Pengiriman:</span>
                                <span class="meta-value">Gratis ongkir untuk pembelian di atas Rp 500.000</span>
                            </div>
                        </div>

                        <div class="purchase-section">
                            <div class="quantity-section">
                                <div class="quantity-label">Jumlah:</div>
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="changeQuantity(-1)">-</button>
                                    <input type="number" value="1" min="1" max="10" 
                                           class="quantity-input" id="quantity">
                                    <button class="quantity-btn" onclick="changeQuantity(1)">+</button>
                                </div>
                            </div>

                            <button class="add-to-cart-btn" onclick="addToCart()">
                                Tambah ke Keranjang
                            </button>

                            <a href="{{ route('products.cart') }}" class="buy-now-btn">
                                Beli Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const productId = {{ $product['id'] }};

        function changeQuantity(delta) {
            const quantityInput = document.getElementById('quantity');
            let currentQuantity = parseInt(quantityInput.value);
            let newQuantity = currentQuantity + delta;
            
            if (newQuantity < 1) newQuantity = 1;
            if (newQuantity > 10) newQuantity = 10;
            
            quantityInput.value = newQuantity;
        }

        function addToCart() {
            const quantity = parseInt(document.getElementById('quantity').value);
            
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('cartCount').textContent = data.cart_count;
                    
                    document.getElementById('quantity').value = 1;
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        document.getElementById('quantity').addEventListener('change', function() {
            let value = parseInt(this.value);
            if (value < 1) value = 1;
            if (value > 10) value = 10;
            this.value = value;
        });


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