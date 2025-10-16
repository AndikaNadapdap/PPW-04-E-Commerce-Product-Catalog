<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - E-Commerce</title>
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

        .cart-section {
            background: white;
            margin: 20px 0;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .cart-header {
            background: #34495e;
            color: white;
            padding: 20px;
        }

        .cart-content {
            padding: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid #eee;
            gap: 20px;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #3498db, #2980b9);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 0.8rem;
            text-align: center;
            flex-shrink: 0;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }

        .item-price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 1rem;
        }

        .item-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .quantity-input {
            width: 60px;
            text-align: center;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 3px;
        }

        .item-total {
            font-weight: bold;
            color: #27ae60;
            min-width: 120px;
            text-align: right;
        }

        .remove-btn {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .cart-summary {
            background: #f8f9fa;
            padding: 25px;
            border-top: 2px solid #dee2e6;
            margin-top: 20px;
        }

        .cart-actions {
            padding: 12px 25px;
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
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .cart-actions {
            display: flex;
            gap: 15px;
            justify-content: space-between;
            margin-top: 20px;
        }

        .empty-cart {
            text-align: center;
            padding: 50px 20px;
            color: #7f8c8d;
        }

        .empty-cart h3 {
            margin-bottom: 15px;
            color: #95a5a6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cart-item {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .item-controls {
                justify-content: center;
                width: 100%;
            }

            .cart-actions {
                flex-direction: column;
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
                <div>
                    <a href="{{ route('products.index') }}" style="color: white; text-decoration: none;">
                        ← Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="cart-section">
                <div class="cart-header">
                    <h1>Keranjang Belanja</h1>
                </div>

                <div class="cart-content">
                    @if(count($cart) > 0)
                        @foreach($cart as $id => $item)
                            <div class="cart-item" id="cart-item-{{ $id }}">
                                <div class="item-image">
                                   
                                </div>
                                <div class="item-details">
                                    <div class="item-name">{{ $item['name'] }}</div>
                                    <div class="item-price">
                                        Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="item-controls">
                                    <div class="quantity-controls">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] - 1 }})">
                                            -
                                        </button>
                                        <input type="number" value="{{ $item['quantity'] }}" 
                                               min="1" max="10" class="quantity-input"
                                               id="qty-{{ $id }}"
                                               onchange="updateQuantity({{ $id }}, this.value)">
                                        <button class="quantity-btn" onclick="updateQuantity({{ $id }}, {{ $item['quantity'] + 1 }})">
                                            +
                                        </button>
                                    </div>
                                    <div class="item-total" id="total-{{ $id }}">
                                        Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                    </div>
                                    <button class="remove-btn" onclick="removeFromCart({{ $id }})">
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        @endforeach

                        <div class="cart-summary">
                            <div class="cart-actions">
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                    ← Lanjut Belanja
                                </a>
                                <a href="{{ route('products.checkout') }}" class="btn btn-success">
                                    Checkout →
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="empty-cart">
                            <h3>Keranjang Belanja Kosong</h3>
                            <p>Belum ada produk dalam keranjang belanja Anda.</p>
                            <br>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Update quantity
        function updateQuantity(productId, newQuantity) {
            if (newQuantity < 0) return;
            
            fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: parseInt(newQuantity)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (newQuantity == 0) {
                        // Remove item from display
                        document.getElementById(`cart-item-${productId}`).remove();
                        
                        // Check if cart is empty
                        if (document.querySelectorAll('.cart-item').length === 0) {
                            location.reload();
                        }
                    } else {
                        // Update quantity input
                        document.getElementById(`qty-${productId}`).value = newQuantity;
                        
                        // Update item total (calculate from price and new quantity)
                        const priceText = document.querySelector(`#cart-item-${productId} .item-price`).textContent;
                        const price = parseInt(priceText.replace(/[^\d]/g, ''));
                        const itemTotal = price * newQuantity;
                        document.getElementById(`total-${productId}`).textContent = 
                            'Rp ' + itemTotal.toLocaleString('id-ID');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function removeFromCart(productId) {
            fetch('/cart/remove', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`cart-item-${productId}`).remove();
                    
                    if (document.querySelectorAll('.cart-item').length === 0) {
                        location.reload();
                    } else {
                        
                        location.reload();
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>