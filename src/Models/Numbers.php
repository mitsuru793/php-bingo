<?php
declare(strict_types=1);

namespace App\Models;

final class Numbers implements \IteratorAggregate, \JsonSerializable
{
    /** @var int[] */
    private $nums;

    public function __construct(array $nums = [])
    {
        $this->nums = [];
        foreach ($nums as $n) {
            $this->nums[$n] = $n;
        }
    }

    public static function create(int $start, int $end): self
    {
        $nums = range($start, $end);
        return new self($nums);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->nums);
    }

    public function jsonSerialize()
    {
        return array_values($this->nums);
    }

    public function shuffle(): self
    {
        $newNums = $this->nums;
        shuffle($newNums);
        return new self($newNums);
    }

    public function push(int $num): self
    {
        $this->nums[$num] = $num;
        return $this;
    }

    public function pop(): int
    {
        return array_pop($this->nums);
    }

    public function has(int $num): bool
    {
        return array_key_exists($num, $this->nums);
    }

    public function isEmpty(): bool
    {
        return empty($this->nums);
    }
}
