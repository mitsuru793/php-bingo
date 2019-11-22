<?php
declare(strict_types=1);

namespace Php\Models;

final class Element
{
    /** @var int */
    public $number;

    /** @var bool */
    public $isHit;

    /** @var bool */
    public $isCenter;

    public function __construct(int $number, bool $isHit)
    {
        $this->number = $number;
        $this->isHit = $isHit;
        $this->isCenter = $this->number === 0;
    }

    public function __toString(): string
    {
        ob_start(); ?>
        <div class="element <?= isT($this->isCenter, 'center') ?> <?= isT($this->isHit, 'hit') ?> ">
            <?= $this->isCenter ? 'Free' : $this->number ?>
        </div>
        <? return ob_get_clean();
    }
}
