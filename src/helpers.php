<?php
declare(strict_types=1);

/**
 * @param mixed $value
 * @return mixed
 */
function cast($value, callable $callback)
{
    return $callback($value);
}

/**
 * @return mixed
 */
function jsonCast(string $json, callable $callback)
{
    return cast(json_decode($json), $callback);
}

function rangeMap(int $min, int $max, callable $fn)
{
    $result = [];
    for ($i = $min; $i <= $max; $i++) {
        $result[] = $fn($i);
    }
    return $result;
}

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
