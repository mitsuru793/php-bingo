<?php
declare(strict_types=1);

namespace Php\Models;

final class Numbers
{
    /** @var int[] */
    private $nums;

    public function __construct(array $nums)
    {
        $this->nums = $nums;
    }

    public static function create(int $start, int $end): self
    {
        $nums = range($start, $end);
        return new self($nums);
    }

    public function shuffle(): self
    {
        $newNums = $this->nums;
        shuffle($newNums);
        return new self($newNums);
    }

    public function pop(): int
    {
        return array_pop($this->nums);
    }
}
