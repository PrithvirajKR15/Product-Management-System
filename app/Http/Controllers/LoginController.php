<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        try {
            if (Auth::guard('admins')->check()) {
                return redirect()->route('admin.dashboard');
            }

            return view('auth.login');
        } catch (\Exception $e) {
            Log::error('Failed to show login form: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $admin = Admin::where('email', $credentials['email'])->first();

            if ($admin && Hash::check($credentials['password'], $admin->password)) {
                Auth::guard('admins')->login($admin, $request->filled('remember'));

                $request->session()->regenerate();

                return redirect()->intended(route('admin.dashboard'));
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        } catch (\Exception $e) {
            Log::error('Failed to login: ' . $e->getMessage(), [
                'exception' => $e,
                'email' => $request->input('email'),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            Auth::guard('admins')->logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login');
        } catch (\Exception $e) {
            Log::error('Failed to logout: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
        }
    }
}
