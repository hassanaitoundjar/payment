<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .order-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .product-info {
            margin-bottom: 20px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Thank You for Your Purchase!</h1>
        <p>Order #{{ $order->order_number }}</p>
    </div>

    <div class="order-details">
        <div class="product-info">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
        </div>

        <div class="total">
            Total: {{ $order->amount }} {{ $order->currency }}
        </div>
    </div>

    <p>Your digital product will be available for download once the payment is confirmed.</p>

    <p>If you have any questions about your order, please contact our support team.</p>

    <p>Best regards,<br>{{ config('app.name') }}</p>
</body>
</html>
