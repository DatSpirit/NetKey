<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Mail\SupportTicketMail;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    /**
     * Hiển thị trang Trung tâm Trợ giúp (Help Center).
     */
    public function helpCenter()
    {
        $faqs = [
            ['question' => 'Làm thế nào để tạo đơn hàng mới?', 'answer' => 'Truy cập trang Sản phẩm, chọn gói phù hợp và nhấn "Mua ngay". Bạn có thể thanh toán bằng ví CoinKey hoặc chuyển khoản qua QR.'],
            ['question' => 'Quy trình xử lý giao dịch là gì?', 'answer' => 'Sau khi thanh toán thành công, hệ thống sẽ tự động cấp Key cho bạn trong vòng vài giây. Bạn có thể xem Key tại mục "Manage Keys".'],
            ['question' => 'Làm sao để nạp tiền vào ví CoinKey?', 'answer' => 'Vào mục "Ví CoinKey" → "Mua gói nạp" → chọn mệnh giá → quét mã QR chuyển khoản. Số dư sẽ được cộng tự động sau vài giây.'],
            ['question' => 'Key của tôi bị hết hạn, phải làm gì?', 'answer' => 'Vào "Manage Keys" → tìm key hết hạn → nhấn "Gia hạn" → chọn phương thức thanh toán và xác nhận.'],
            ['question' => 'Tôi có thể đặt tên Key tự chọn không?', 'answer' => 'Có! Khi mua key, chọn "Custom Key" và nhập mã Key theo ý muốn (chỉ chứa chữ, số và dấu gạch ngang).'],
        ];

        return view('support.help_center', compact('faqs'));
    }

    /**
     * Hiển thị trang Liên hệ Hỗ trợ (Contact Support).
     */
    public function contactSupport()
    {
        return view('support.contact_support');
    }

    /**
     * Xử lý gửi biểu mẫu liên hệ.
     * UC-14: Lưu ticket vào DB và gửi email thông báo cho Admin qua Queue.
     */
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10|max:5000',
        ], [
            'name.required'    => 'Vui lòng nhập họ tên.',
            'email.required'   => 'Vui lòng nhập địa chỉ email.',
            'email.email'      => 'Địa chỉ email không hợp lệ.',
            'subject.required' => 'Vui lòng nhập tiêu đề yêu cầu.',
            'message.required' => 'Vui lòng nhập nội dung yêu cầu.',
            'message.min'      => 'Nội dung yêu cầu phải có ít nhất 10 ký tự.',
        ]);

        try {
            // 1. Lưu ticket vào Database
            $ticket = SupportTicket::create([
                'user_id'    => Auth::id(), // null nếu chưa đăng nhập
                'name'       => $validated['name'],
                'email'      => $validated['email'],
                'subject'    => $validated['subject'],
                'message'    => $validated['message'],
                'status'     => 'open',
                'ip_address' => $request->ip(),
            ]);

            // 2. Gửi email thông báo cho Admin qua Queue Worker (bất đồng bộ)
            $adminEmail = env('MAIL_ADMIN_ADDRESS') ?: env('MAIL_FROM_ADDRESS');
            if ($adminEmail) {
                Mail::to($adminEmail)->queue(new SupportTicketMail($ticket));
            }

            Log::info("Support ticket #{$ticket->id} created by {$validated['email']}");

            return back()->with('success', '✅ Yêu cầu hỗ trợ của bạn đã được gửi thành công! Chúng tôi sẽ phản hồi trong vòng 24 giờ.');

        } catch (\Exception $e) {
            Log::error('Support ticket submission error: ' . $e->getMessage());
            return back()->withInput()->with('error', '❌ Có lỗi xảy ra khi gửi yêu cầu. Vui lòng thử lại.');
        }
    }

    /**
     * Admin: Xem danh sách tất cả support tickets.
     */
    public function adminIndex(Request $request)
    {
        $query = SupportTicket::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        $tickets = $query->paginate(20);
        $stats = [
            'open'        => SupportTicket::where('status', 'open')->count(),
            'in_progress' => SupportTicket::where('status', 'in_progress')->count(),
            'closed'      => SupportTicket::where('status', 'closed')->count(),
            'total'       => SupportTicket::count(),
        ];

        return view('admin.support.index', compact('tickets', 'stats'));
    }

    /**
     * Admin: Xem chi tiết ticket.
     */
    public function adminShow(SupportTicket $ticket)
    {
        return view('admin.support.show', compact('ticket'));
    }

    /**
     * Admin: Cập nhật trạng thái ticket.
     */
    public function adminUpdateStatus(Request $request, SupportTicket $ticket)
    {
        $request->validate(['status' => 'required|in:open,in_progress,closed']);
        $ticket->update(['status' => $request->status]);

        return back()->with('success', 'Đã cập nhật trạng thái ticket.');
    }
}