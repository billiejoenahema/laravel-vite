<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Enums\Prefecture;

return [
    'GENDER' => Gender::toArray(),
    'PREFECTURE' => Prefecture::toArray(),
    'MAX_UPLOAD_SIZE' => 1024 * 1024 * 10, // 最大10MB
];
