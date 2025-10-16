<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil - E-Commerce</title>
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
            max-width: 800px;
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

        .success-section {
            background: white;
            margin: 30px 0;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .success-header {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            display: block;
        }

        .success-title {
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .success-subtitle {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        .order-details {
            padding: 40px 30px;
        }

        .order-info {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            padding: 8px 0;
        }

        .info-row:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .info-value {
            color: #34495e;
            text-align: right;
        }

        .order-id {
            background: #3498db;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 25px;
        }

        .order-id strong {
            font-size: 1.2rem;
        }

        .customer-section, .items-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #2c3e50;
            border-bottom: 2px solid #ecf0f1;
            padding-bottom: 10px;
        }

        .customer-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .customer-row {
            margin-bottom: 12px;
        }

        .customer-row:last-child {
            margin-bottom: 0;
        }

        .customer-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .customer-value {
            color: #34495e;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #ecf0f1;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .item-quantity {
            color: #7f8c8d;
            font-size: 0.9rem;
        }

        .item-total {
            font-weight: bold;
            color: #27ae60;
        }

        .order-total {
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
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

        .payment-info {
            background: #e3f2fd;
            border: 1px solid #90caf9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .payment-method {
            font-weight: 600;
            color: #1565c0;
            margin-bottom: 10px;
        }

        .payment-instructions {
            color: #1976d2;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        .actions {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #ecf0f1;
        }

        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
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
        }

        .btn-success {
            background: #27ae60;
            color: white;
        }

        .progress-section {
            background: white;
            padding: 20px;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
        }

        .progress-step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .step-number {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #27ae60;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-bottom: 8px;
            color: white;
        }

        .step-title {
            font-size: 0.9rem;
            color: #2c3e50;
            text-align: center;
            font-weight: 600;
        }

        .progress-line {
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 3px;
            background: #27ae60;
            z-index: 1;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .success-header {
                padding: 30px 20px;
            }

            .success-title {
                font-size: 1.5rem;
            }

            .order-details {
                padding: 20px;
            }

            .actions {
                flex-direction: column;
                align-items: center;
            }

            .btn {
                width: 100%;
                max-width: 300px;
            }

            .info-row {
                flex-direction: column;
                gap: 5px;
            }

            .info-value {
                text-align: left;
            }

            .progress-steps {
                flex-wrap: wrap;
                gap: 15px;
                justify-content: center;
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
            </div>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="success-section">
                <div class="success-header">

                    <h1 class="success-title">Pesanan Berhasil!</h1>
                    <p class="success-subtitle">Terima kasih telah berbelanja di toko kami</p>
                </div>

                <div class="order-details">
                    <div class="order-id">
                        <strong>ID Pesanan: {{ $order['order_id'] }}</strong>
                        <div style="font-size: 0.9rem; margin-top: 5px; opacity: 0.9;">
                            {{ $order['order_date']->format('d F Y, H:i') }} WIB
                        </div>
                    </div>

                    <div class="customer-section">
                        <h3 class="section-title">Informasi Pembeli</h3>
                        <div class="customer-info">
                            <div class="customer-row">
                                <div class="customer-label">Nama:</div>
                                <div class="customer-value">{{ $order['customer']['name'] }}</div>
                            </div>
                            <div class="customer-row">
                                <div class="customer-label">Email:</div>
                                <div class="customer-value">{{ $order['customer']['email'] }}</div>
                            </div>
                            <div class="customer-row">
                                <div class="customer-label">Telepon:</div>
                                <div class="customer-value">{{ $order['customer']['phone'] }}</div>
                            </div>
                            <div class="customer-row">
                                <div class="customer-label">Alamat:</div>
                                <div class="customer-value">{{ $order['customer']['address'] }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="items-section">
                        <h3 class="section-title">Item Pesanan</h3>
                        @foreach($order['items'] as $item)
                            <div class="order-item">
                                <div class="item-details">
                                    <div class="item-name">{{ $item['name'] }}</div>
                                    <div class="item-quantity">
                                        {{ $item['quantity'] }} × Rp {{ number_format($item['price'], 0, ',', '.') }}
                                    </div>
                                </div>
                                <div class="item-total">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach

                        <div class="order-total">
                            <div class="total-row grand-total">
                                <span>Total Pembayaran:</span>
                                <span>Rp {{ number_format($order['total'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="payment-info">
                        <div class="payment-method">
                            Metode Pembayaran: 
                            @switch($order['payment_method'])
                                @case('bank_transfer')
                                    Transfer Bank
                                    @break
                                @case('ewallet')
                                    E-Wallet
                                    @break
                                @case('cod')
                                    Bayar di Tempat (COD)
                                    @break
                                @default
                                    {{ ucfirst(str_replace('_', ' ', $order['payment_method'])) }}
                            @endswitch
                        </div>
                        <div class="payment-instructions">
                            @switch($order['payment_method'])
                                @case('bank_transfer')
                                    Silakan lakukan transfer ke rekening yang akan dikirimkan melalui email. 
                                    Pesanan akan diproses setelah pembayaran dikonfirmasi.
                                    @break
                                @case('ewallet')
                                    Link pembayaran e-wallet akan dikirimkan melalui SMS/WhatsApp. 
                                    Mohon selesaikan pembayaran dalam 24 jam.
                                    @break
                                @case('cod')
                                    Pembayaran akan dilakukan saat barang diterima. 
                                    Pastikan menyiapkan uang pas sesuai total pembayaran.
                                    @break
                                @default
                                    Instruksi pembayaran akan dikirimkan melalui email.
                            @endswitch
                        </div>
                    </div>

                    <div class="actions">
                        <a href="{{ route('products.index') }}" class="btn btn-primary">
                            Lanjut Belanja
                        </a>
                        <button onclick="window.print()" class="btn btn-success">
                            Cetak Pesanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.scrollTo(0, 0);

        history.replaceState(null, '', '{{ route('products.order-success') }}');
    </script>
</body>
</html>