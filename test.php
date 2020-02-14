<?php
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$nums = [
    5 => 'v5',
    2 => 'v2',
    12 => 'v12',
];

dump(
 array_slice($nums, 0, 2)
);
