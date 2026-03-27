<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #1e3a5f; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
        .field { margin-bottom: 12px; }
        .label { font-weight: bold; color: #555; font-size: 12px; text-transform: uppercase; }
        .value { background: white; padding: 8px 12px; border-left: 3px solid #3b82f6; margin-top: 4px; }
        .footer { background: #eee; padding: 12px 20px; border-radius: 0 0 8px 8px; font-size: 12px; color: #777; }
        .badge { display: inline-block; padding: 2px 10px; background: #f59e0b; color: white; border-radius: 12px; font-size: 12px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2 style="margin:0">🎫 Ticket hỗ trợ mới #{{ $ticket->id }}</h2>
        <p style="margin:6px 0 0; opacity:0.8">NetKey Support System</p>
    </div>
    <div class="content">
        <p>Một yêu cầu hỗ trợ mới đã được gửi. Chi tiết bên dưới:</p>

        <div class="field">
            <div class="label">Trạng thái</div>
            <div><span class="badge">OPEN</span></div>
        </div>

        <div class="field">
            <div class="label">Người gửi</div>
            <div class="value">{{ $ticket->name }} &lt;{{ $ticket->email }}&gt;</div>
        </div>

        <div class="field">
            <div class="label">Tiêu đề</div>
            <div class="value">{{ $ticket->subject }}</div>
        </div>

        <div class="field">
            <div class="label">Nội dung</div>
            <div class="value" style="white-space: pre-wrap;">{{ $ticket->message }}</div>
        </div>

        <div class="field">
            <div class="label">Thời gian gửi</div>
            <div class="value">{{ $ticket->created_at->format('H:i:s d/m/Y') }}</div>
        </div>

        @if($ticket->ip_address)
        <div class="field">
            <div class="label">IP Address</div>
            <div class="value">{{ $ticket->ip_address }}</div>
        </div>
        @endif
    </div>
    <div class="footer">
        Đây là email tự động từ hệ thống NetKey. Vui lòng trả lời trực tiếp cho khách: {{ $ticket->email }}
    </div>
</div>
</body>
</html>
