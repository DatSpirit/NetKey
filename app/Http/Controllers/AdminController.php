<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminAuditLog;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use App\Models\Transaction;

class AdminController extends Controller
{
    /**
     * Hiển thị trang quản lý người dùng ( Admin).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $filter = $request->input('filter', 'all'); // Mặc định lọc tất cả "all"

        // Xác định cột lọc
        $query = User::query();

        // Xử lý lọc theo trạng thái (Xóa mềm)
        if ($request->get('status') === 'deleted') {
            $query->onlyTrashed();
        }

        if ($search) {
            if ($filter === 'all') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%")
                        ->orWhere('id', 'LIKE', "%{$search}%")
                        ->orWhere('phone_number', 'LIKE', "%{$search}%")
                        ->orWhere('notes', 'LIKE', "%{$search}%");
                });
            } else {
                // Giới hạn các cột được phép lọc
                $allowedFilters = ['name', 'email', 'phone_number'];
                if (in_array($filter, $allowedFilters)) {
                    $query->where($filter, 'LIKE', "%{$search}%");
                }
            }
        }

        // Lấy danh sách người dùng, phân trang 20 user mỗi trang
        $users = $query->orderBy('created_at', 'desc')
            ->paginate(20)
            ->withQueryString();

        // Trả về view với danh sách user
        return view('admin.users', compact('users', 'search', 'filter'));
    }

    /**
     * Trả về thông tin chi tiết người dùng (dùng cho xem trước qua AJAX).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id): JsonResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        // Explicitly include fields that may be affected by hidden/cast rules
        return response()->json([
            'id'                    => $user->id,
            'name'                  => $user->name,
            'email'                 => $user->email,
            'phone_number'          => $user->phone_number,
            'is_admin'              => $user->is_admin,
            'two_factor_enabled'    => (bool) $user->two_factor_enabled,
            'two_factor_confirmed_at' => $user->two_factor_confirmed_at,
            'expires_at'            => $user->expires_at,
            'account_status'        => $user->account_status,
            'notes'                 => $user->notes,
            'created_at'            => $user->created_at,
            'updated_at'            => $user->updated_at,
            'deleted_at'            => $user->deleted_at,
        ]);
    }

    /**
     * Gợi ý người dùng theo tên, email, ID (AJAX).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function suggestions(Request $request): JsonResponse
    {
        $query = trim($request->input('q'));
        $filter = $request->input('filter', 'all');

        // Đảm bảo filter hợp lệ
        if (!in_array($filter, ['all', 'name', 'email', 'phone_number'])) {
            $filter = 'all';
        }

        if (strlen($query) < 1) {
            return response()->json([]);
        }

        $dbQuery = User::select('id', 'name', 'email', 'phone_number');

        if ($filter === 'all') {
            $dbQuery->where(function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhere('phone_number', 'LIKE', "%{$query}%");
            })->limit(10);
        } else {
            $dbQuery->where($filter, 'like', "%{$query}%")
                ->orderByRaw("
                    CASE 
                        WHEN LOWER({$filter}) LIKE ? THEN 1 
                        WHEN LOWER({$filter}) LIKE ? THEN 2 
                        WHEN LOWER({$filter}) LIKE ? THEN 3 
                        ELSE 4 
                    END, {$filter} ASC
                ", [
                    strtolower("{$query}%"),
                    strtolower("% {$query}%"),
                    strtolower("%{$query}%")
                ])
                ->limit(10);
        }

        return response()->json($dbQuery->get());
    }

    /**
     * Hiển thị form chỉnh sửa người dùng.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user): View
    {
        return view('admin.edit', compact('user'));
    }

    /**
     * Cập nhật thông tin người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // Validate dữ liệu nhập vào
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'required|string|max:20',
            'notes' => 'nullable|string|max:1000',
        ]);

        $oldValues = $user->only(['name', 'email', 'phone_number', 'notes']);

        // Cập nhật user
        $user->update($validated);

        // Ghi Audit Log
        AdminAuditLog::log(
            action: 'update_user',
            targetType: 'User',
            targetId: $user->id,
            description: "Sửa thông tin user: {$user->email}",
            old: $oldValues,
            new: $user->fresh()->only(['name', 'email', 'phone_number', 'notes'])
        );

        // Chuyển hướng về danh sách user với thông báo
        return redirect()
            ->route('admin.users')
            ->with('success', __('User updated successfully.'));
    }

    /**
     * Xóa người dùng.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        // Không cho phép xóa chính Admin hiện tại và các admin khác
        if (auth()->id() === $user->id) {
            return redirect()
                ->route('admin.users')
                ->with('error', __('You cannot delete your own account.'));
        }

        // Không cho phép xóa admin khác
        if ($user->isAdmin()) {
            return redirect()
                ->route('admin.users')
                ->with('error', __('You cannot delete another admin account.'));
        }

        $userEmail = $user->email;
        $userId = $user->id;
        $user->delete();

        // Ghi Audit Log
        AdminAuditLog::log(
            action: 'delete_user',
            targetType: 'User',
            targetId: $userId,
            description: "Xóa user: {$userEmail}",
        );

        return redirect()
            ->route('admin.users')
            ->with('success', __('User deleted successfully.'));
    }

    /**
     * Khôi phục người dùng đã xóa mềm.
     */
    public function restore($id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        // Ghi Audit Log
        AdminAuditLog::log(
            action: 'restore_user',
            targetType: 'User',
            targetId: $user->id,
            description: "Khôi phục user: {$user->email}",
        );

        return redirect()
            ->route('admin.users', ['status' => 'deleted'])
            ->with('success', __('User restored successfully.'));
    }

    /**
     * Xóa vĩnh viễn người dùng.
     */
    public function forceDelete($id): RedirectResponse
    {
        $user = User::withTrashed()->findOrFail($id);

        // Không cho phép xóa chính Admin hiện tại
        if (auth()->id() == $user->id) {
            return redirect()
                ->route('admin.users')
                ->with('error', __('You cannot permanently delete your own account.'));
        }

        $userEmail = $user->email;
        $userId = $user->id;
        $user->forceDelete();

        // Ghi Audit Log
        AdminAuditLog::log(
            action: 'force_delete_user',
            targetType: 'User',
            targetId: $userId,
            description: "Xóa vĩnh viễn user: {$userEmail}",
        );

        return redirect()
            ->route('admin.users', ['status' => 'deleted'])
            ->with('success', __('User permanently deleted.'));
    }
}
