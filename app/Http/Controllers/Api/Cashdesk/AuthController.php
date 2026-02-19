<?php

namespace App\Http\Controllers\Api\Cashdesk;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private const WAREHOUSE_REQUIRED_ROLES = ['admin', 'manager', 'cashier'];

    public function login(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'phone' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
            'device_name' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::with('warehouse')
            ->where('phone', trim($validated['phone']))
            ->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Неверный номер телефона или пароль.',
            ], 422);
        }

        if (!$user->status) {
            return response()->json([
                'message' => 'Учетная запись отключена.',
            ], 403);
        }

        if ($this->warehouseIsRequired($user->role) && !$user->warehouse_id) {
            return response()->json([
                'message' => 'Для этой роли требуется привязка к складу.',
            ], 422);
        }

        $remember = (bool) ($validated['remember'] ?? false);
        $token = $user->createToken(
            $validated['device_name'] ?? ('cashdesk-' . Str::uuid()),
            ['cashdesk:*'],
            $remember ? now()->addDays(30) : now()->addHours(12)
        );

        return response()->json([
            'message' => 'Вход выполнен успешно.',
            'token_type' => 'Bearer',
            'token' => $token->plainTextToken,
            'expires_at' => $this->resolveTokenExpiry($token->accessToken?->expires_at),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'role' => $user->role,
                'warehouse_id' => $user->warehouse_id,
                'warehouse' => $user->warehouse ? [
                    'id' => $user->warehouse->id,
                    'name' => $user->warehouse->name,
                    'code' => $user->warehouse->code,
                    'address' => $user->warehouse->address,
                ] : null,
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user()->load('warehouse');

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'phone' => $user->phone,
                'role' => $user->role,
                'warehouse_id' => $user->warehouse_id,
                'warehouse' => $user->warehouse ? [
                    'id' => $user->warehouse->id,
                    'name' => $user->warehouse->name,
                    'code' => $user->warehouse->code,
                    'address' => $user->warehouse->address,
                ] : null,
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()?->delete();

        return response()->json([
            'message' => 'Вы вышли из системы.',
        ]);
    }

    private function warehouseIsRequired(?string $role): bool
    {
        return in_array($role, self::WAREHOUSE_REQUIRED_ROLES, true);
    }

    private function resolveTokenExpiry(null|CarbonInterface|string $expiresAt): ?string
    {
        if ($expiresAt instanceof CarbonInterface) {
            return $expiresAt->toIso8601String();
        }

        if (is_string($expiresAt) && $expiresAt !== '') {
            return $expiresAt;
        }

        return null;
    }
}
