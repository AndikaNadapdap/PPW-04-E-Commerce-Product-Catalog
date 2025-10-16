<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - E-Commerce</title>
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

        .checkout-section {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 30px;
            margin: 20px 0;
        }

        .checkout-form, .order-summary {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
            color: #34495e;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            outline: none;
            border-color: #3498db;
        }

        .form-textarea {
            min-height: 100px;
            resize: vertical;
        }

        .payment-options {
            display: grid;
            gap: 10px;
        }

        .payment-option {
            display: flex;
            align-items: center;
            padding: 15px;
            border: 2px solid #ecf0f1;
            border-radius: 8px;
            cursor: pointer;
        }

        .payment-option.selected {
            margin-right: 12px;
        }

        .payment-option.selected {
            border-color: #3498db;
            background-color: #e3f2fd;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .summary-item:last-child {
            border-bottom: none;
        }

        .item-info {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #2c3e50;
        }

        .item-details {
            font-size: 0.9rem;
            color: #7f8c8d;
        }

        .item-total {
            font-weight: bold;
            color: #27ae60;
        }

        .summary-total {
            background: #f8f9fa;
            padding: 20px;
            margin: 20px -30px -30px -30px;
            border-radius: 0 0 10px 10px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .grand-total {
            border-top: 2px solid #dee2e6;
            padding-top: 15px;
            margin-top: 15px;
            font-size: 1.3rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            font-weight: 600;
        }

        .btn-primary {
            background: #3498db;
            color: white;
            width: 100%;
            margin-top: 20px;
        }

        .btn-secondary {
            background: #95a5a6;
            color: white;
        }

        .checkout-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .checkout-section {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .checkout-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }

            .progress-steps {
                flex-direction: column;
                gap: 15px;
            }

            .progress-line {
                display: none;
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
                    <a href="{{ route('products.cart') }}" style="color: white; text-decoration: none;">
                        ← Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="checkout-section">

                <div class="checkout-form">
                    <h2 class="section-title">Informasi Pembeli</h2>
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-input" 
                                   value="{{ old('name') }}">
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" id="email" name="email" class="form-input" 
                                   value="{{ old('email') }}">
                        </div>

                        <div class="form-group">
                            <label for="phone" class="form-label">Nomor Telepon</label>
                            <input type="text" id="phone" name="phone" class="form-input" 
                                   value="{{ old('phone') }}">
                        </div>

                        <div class="form-group">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea id="address" name="address" class="form-textarea">{{ old('address') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran</label>
                            <div class="payment-options">
                                <label class="payment-option" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="bank_transfer">
                                    <div>
                                        <strong>Transfer Bank</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            Transfer ke rekening bank
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="ewallet">
                                    <div>
                                        <strong>E-Wallet</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            GoPay, OVO, Dana, ShopeePay
                                        </div>
                                    </div>
                                </label>
                                
                                <label class="payment-option" onclick="selectPayment(this)">
                                    <input type="radio" name="payment_method" value="cod">
                                    <div>
                                        <strong>Bayar di Tempat (COD)</strong>
                                        <div style="font-size: 0.9rem; color: #666;">
                                            Bayar saat barang diterima
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Proses Pembayaran
                        </button>
                    </form>
                </div>

                <div class="order-summary">
                    <h3 class="section-title">Ringkasan Pesanan</h3>
                    
                    @foreach($cart as $id => $item)
                        <div class="summary-item">
                            <div class="item-info">
                                <div class="item-name">{{ $item['name'] }}</div>
                                <div class="item-details">
                                    {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="item-total">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach

                    <div class="summary-total">
                        <div class="total-row grand-total">
                            <span>Total Pembayaran:</span>
                            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="checkout-actions" style="max-width: 800px;">
                <a href="{{ route('products.cart') }}" class="btn btn-secondary">
                    ← Kembali ke Keranjang
                </a>
            </div>
        </div>
    </main>

    <script>
        function selectPayment(element) {
            document.querySelectorAll('.payment-option').forEach(option => {
                option.classList.remove('selected');
            });

            element.classList.add('selected');

            element.querySelector('input[type="radio"]').checked = true;
        }

        document.getElementById('phone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d]/g, '');
            if (value.startsWith('0')) {
                value = '+62' + value.slice(1);
            }
            e.target.value = value;
        });
    </script>
</body>
</html>