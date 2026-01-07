<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Handlers\AuthHandler;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    private AuthHandler $authHandler;
    public function __construct(
        AuthHandler $authHandler
    ) {
        $this->authHandler = $authHandler;
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();
        try {
            $user = $this->authHandler->authenticate(
                $request->email,
                $validated['password']
            );

            $tokenData = $this->authHandler->createToken(
                $user,
                $validated['remember_me'] ?? false
            );

            return ResponseHelper::success([
                'user'         => $user,
                'role'         => $user->getRoleNames()->first(),
                'access_token' => $tokenData['token'],
                'token_type'   => 'Bearer',
                'expires_at'   => $tokenData['expires_at']->toDateTimeString(),
            ], trans('auth.login_success'), 200);
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: $e->getMessage(),
                code: 400
            );
        }
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();
        DB::beginTransaction();
        try {
            $user = $this->authHandler->register($validated);
            DB::commit();
            return ResponseHelper::success(
                data: $user,
                message: trans('auth.register_success'),
                code: 201
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseHelper::error(
                message: trans('auth.registration_failed ') . ': ' . $e->getMessage(),
                code: 400
            );
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authHandler->logout($request->user());

            return ResponseHelper::success(
                message: trans('auth.logout_success'),
                code: 200
            );
        } catch (\Exception $e) {
            return ResponseHelper::error(
                message: trans('auth.logout_error'),
                code: 400
            );
        }
    }
}
