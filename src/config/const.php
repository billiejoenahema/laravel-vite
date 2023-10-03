<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Enums\Prefecture;

return [
    'GENDER' => Gender::toArray(),
    'PREFECTURE' => Prefecture::toArray(),
    'PER_PAGE' => [
        ['id' => 10, 'name' => '10件'],
        ['id' => 20, 'name' => '20件'],
        ['id' => 30, 'name' => '30件'],
        ['id' => 40, 'name' => '40件'],
        ['id' => 50, 'name' => '50件'],
    ],
    'MAX_UPLOAD_SIZE' => 1024 * 1024 * 10, // 最大10MB
];
