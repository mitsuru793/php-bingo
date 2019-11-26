<?php
declare(strict_types=1);

namespace App\Domain\Game;

use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function testDrawLots()
    {
        $game = new Game(1, null, GameNumbers::create(3, 1));
        $nums = $game->numbers;
        $this->assertCount(count($nums->left), $nums->all);

        $leftCount = count($nums->left);
        $drawNums[] = $game->drawLots();
        $drawNums[] = $game->drawLots();
        $this->assertCount($leftCount - 2, $game->numbers->left);

        $this->assertContains($drawNums[0], $game->numbers->all);
        $this->assertContains($drawNums[0], $game->numbers->hit);
        $this->assertNotContains($drawNums[0], $game->numbers->left);
    }
}
