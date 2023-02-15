<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
//        Permission::create(['name' => 'super']);
//        Permission::create(['name' => 'company']);
//        Permission::create(['name' => 'client']);
//        $user = Auth::user();
//        $user->givePermissionTo('super');
        $user = Auth::user();
        $role = $user->role;

        if ($user->status == 0 || $role != 'company') {
            Auth::guard('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            return redirect('/');
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
