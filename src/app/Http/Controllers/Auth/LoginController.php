<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final class LoginController extends Controller
{
    /**
     * @param AuthManager $auth
     */
    public function __construct(
        private AuthManager $auth,
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only(['email', 'password']);
        if ($this->auth->guard()->attempt($credentials)) {

            $request->session()->regenerate();
            $user = Auth::user();
            // 最終ログイン日時を更新する
            $user->last_login_at = now();
            $user->save();

            return new JsonResponse([
                'message' => 'ログイン成功。',
            ]);
        }

        throw new AuthenticationException();
    }
}
