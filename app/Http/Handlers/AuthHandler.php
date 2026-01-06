<?php

namespace App\Http\Handlers;

use App\Models\User;
use App\Interfaces\AuthInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Repositories\User\UserRepositoryInterface;

class AuthHandler
{
    protected AuthInterface $authRepository;
    public function __construct(
        AuthInterface $authRepository
    ) {
        $this->authRepository = $authRepository;
    }

    public function authenticate(string $email, string $password): User
    {
        $user = $this->authRepository->findByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [trans('auth.invalid_credentials')],
            ]);
        }

        return $user;
    }

    public function createToken(User $user, bool $rememberMe = false): array
    {
        $expiresAt = $rememberMe
            ? now()->addDays(30)
            : now()->addDay();

        $token = $user->createToken(
            'api-token',
            ['*'],
            $expiresAt
        )->plainTextToken;

        return [
            'token' => $token,
            'expires_at' => $expiresAt,
        ];
    }

    public function register(array $data): User
    {
        return $this->authRepository->store($data);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }
}
