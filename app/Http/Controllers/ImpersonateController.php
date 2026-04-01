<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonateController extends Controller
{
    public function start(User $user): RedirectResponse
    {
        // Guardamos el ID del admin en sesión
        session(['impersonating_admin_id' => auth()->id()]);

        Auth::login($user);

        return redirect()->route('pedidos.index')
            ->with('success', 'Estás viendo la app como ' . $user->name . '.');
    }

    public function stop(): RedirectResponse
    {
        $adminId = session('impersonating_admin_id');

        if (! $adminId) {
            return redirect()->route('pedidos.index');
        }

        $admin = User::findOrFail($adminId);

        session()->forget('impersonating_admin_id');

        Auth::login($admin);

        return redirect()->route('users.index')
            ->with('success', 'Volviste a tu cuenta de admin.');
    }
}
