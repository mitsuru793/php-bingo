<?php
declare(strict_types=1);

namespace App\Models;

final class Rows implements \IteratorAggregate
{
    /** @var Element[][] */
    private $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public static function create(int $size, Numbers $nums, Numbers $hits): self
    {
        assert(isOdd($size));
        $center = (int)floor($size / 2) + 1;
        $centerI = $center - 1;

        $rows = [];
        for ($rowI = 0; $rowI < 5; $rowI++) {
            $row = [];
            for ($columnI = 0; $columnI < 5; $columnI++) {
                $isCenter = ($centerI === $rowI && $centerI === $columnI);
                $row[] = $isCenter ? 0 : $nums->pop();
            }
            $rows[] = $row;
        }

        $rows = array_map(function ($row) use ($hits) {
            return array_map(function (int $num) use ($hits) {
                $isHit = $hits->has($num);
                return new Element($num, $isHit);
            }, $row);
        }, $rows);

        return new self($rows);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->rows);
    }
}
