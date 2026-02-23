<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:student,teacher,admin'],
            'security_code' => ['nullable', 'string'],
        ]);

        // Kiểm tra mã bảo mật nếu chọn vai trò nhạy cảm
        if (in_array($request->role, ['teacher', 'admin'])) {
            if ($request->security_code !== 'KANI2025') {
                return back()->withErrors(['security_code' => 'Mã bảo mật không đúng']);
            }
        }

        // Tạo tài khoản với trạng thái duyệt
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'approved' => $request->role === 'student' ? false : true, // học sinh cần duyệt
        ]);

        $user->assignRole($request->role);
        event(new Registered($user));

        // Nếu là học sinh → cập nhật số lượng chờ duyệt vào bảng settings
        if ($request->role === 'student') {
            $pendingCount = User::where('role', 'student')->where('approved', false)->count();

            \DB::table('settings')->updateOrInsert(
                ['key' => 'pending_students_count'],
                ['value' => $pendingCount]
            );

            // Không đăng nhập ngay
            return redirect()->route('login')->with('status', 'Tài khoản của bạn đang chờ duyệt bởi quản trị viên.');
        }

        // Các vai trò khác → đăng nhập luôn
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
