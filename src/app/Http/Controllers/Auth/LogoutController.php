<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

final class LogoutController extends Controller
{
    public function __construct(
        private AuthManager $auth,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        if ($this->auth->guard()->guest()) {
            return new JsonResponse([
                'message' => 'すでにログアウトしています。',
            ]);
        }

        $this->auth->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse([
            'message' => 'ログアウト成功。',
        ]);
    }
}
