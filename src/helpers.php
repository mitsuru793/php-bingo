<?php
declare(strict_types=1);

/**
 * @return mixed
 */
function isT(bool $condition, $val)
{
    if ($condition) {
        return $val;
    }
}

/**
 * @return mixed
 */
function random(array $items)
{
    $key = array_rand($items);
    return $items[$key];
}

function isOdd(int $number): bool
{
    return $number % 2 !== 0;
}

function renderItems(array $items): void
{
    foreach ($items as $item) {
        echo $item;
    }
}
