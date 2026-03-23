<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth::check()) {
            return redirect('login');
        }

        // 2. Cek apakah role user ada dalam daftar role yang diizinkan
        $user = Auth::user();
        if (in_array($user->role, $roles)) {
            return $next($request);
        }
        // 3. Jika tidak punya akses, lempar ke dashboard masing-masing atau error 403
        abort(403, 'Maaf, Anda tidak memiliki akses ke halaman ini.');
    }
}
