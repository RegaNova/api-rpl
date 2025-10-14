<?php

namespace App\Http\Middleware;

// app/Http/Middleware/RoleMiddleware.php
use App\Enums\UserRoleEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (!in_array($role, UserRoleEnum::values())) {
            abort(400, 'Invalid role');
        }

        $user = $request->user();

        // Simulasikan role berdasarkan email
        $adminEmails = ['admin@example.com'];

        $userRole = in_array($user->email, $adminEmails) ? 'admin' : 'user';

        if ($userRole !== $role) {
            return response()->json(['message' => 'Access denied'], 403);
        }

        return $next($request);
    }
}
