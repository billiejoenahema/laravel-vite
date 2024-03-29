<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProfileResource;

final class ProfileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(): ProfileResource
    {
        return new ProfileResource(auth()->user());
    }
}
