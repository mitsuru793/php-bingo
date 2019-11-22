<?php
declare(strict_types=1);

namespace Php\Models;

final class Board
{
    /** @var Numbers */
    public $allNumbers;

    /** @var Numbers */
    public $hitNumbers;

    /** @var Rows */
    public $rows;

    public function __construct(Numbers $allNumbers, Numbers $hitNumbers, Rows $rows)
    {
        $this->allNumbers = $allNumbers;
        $this->hitNumbers = $hitNumbers;
        $this->rows = $rows;
    }
}
