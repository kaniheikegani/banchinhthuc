<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Xác thực email + password
        $request->session()->regenerate(); // Tạo lại session an toàn
        /** @var \App\Models\User $user */
        $user = auth()->user(); // Lấy user đã đăng nhập

        // ✅ Kiểm tra quyền bằng cột role trong bảng users
        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'teacher':
                return redirect()->route('teacher.dashboard');
            case 'student':
                return redirect()->route('student.dashboard');
            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Tài khoản chưa được phân quyền. Vui lòng liên hệ quản trị viên.',
                ]);
        }
    }



    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->flush();        // ← thêm dòng này nếu có dữ liệu tạm
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login'); // hoặc route('login')
    }
}
