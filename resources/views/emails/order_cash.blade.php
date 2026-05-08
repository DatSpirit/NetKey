<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            border-radius: 0 0 10px 10px;
        }
        .order-info {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
        .button {
            display: inline-block;
            padding: 12px 25px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>NetKey</h1>
        <p>Cảm ơn bạn đã tin dùng dịch vụ của chúng tôi!</p>
    </div>
    <div class="content">
        <h2>Thông báo đơn hàng thành công</h2>
        <p>Chào <strong>{{ $transaction->user->name }}</strong>,</p>
        <p>Chúng tôi đã nhận được thanh toán cho đơn hàng của bạn qua phương thức <strong>Chuyển khoản / Tiền mặt (PayOS)</strong>.</p>
        
        <div class="order-info">
            <p><strong>Mã đơn hàng:</strong> #{{ $transaction->order_code }}</p>
            <p><strong>Sản phẩm:</strong> {{ $transaction->product->name }}</p>
            <p><strong>Số tiền:</strong> {{ number_format($transaction->amount) }} {{ $transaction->currency }}</p>
            <p><strong>Thời gian:</strong> {{ $transaction->processed_at->format('H:i d/m/Y') }}</p>
        </div>

        @if($transaction->productKey)
        <p><strong>Key sản phẩm của bạn:</strong></p>
        <div style="background: #eef2ff; padding: 15px; border-left: 5px solid #667eea; font-family: monospace; font-size: 18px;">
            {{ $transaction->productKey->key_code }}
        </div>
        <p>Vui lòng bảo mật thông tin Key này.</p>
        @endif

        <p>Bạn có thể kiểm tra chi tiết đơn hàng tại trang Dashboard:</p>
        <p style="text-align: center;">
            <a href="{{ route('dashboard') }}" class="button">Đi tới Dashboard</a>
        </p>

        <p>Nếu bạn có bất kỳ thắc mắc nào, hãy liên hệ với bộ phận hỗ trợ của chúng tôi.</p>
        <p>Trân trọng,<br>Đội ngũ NetKey</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} NetKey. All rights reserved.
    </div>
</body>
</html>
