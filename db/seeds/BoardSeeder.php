<?php

use Phinx\Seed\AbstractSeed;

class BoardSeeder extends AbstractSeed
{
    public function getDependencies()
    {
        return [
            GameSeeder::class,
        ];
    }

    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        for ($gameId = 1; $gameId <= 3; $gameId++) {
            $this->createBoards($gameId);
        }
    }

    private function createBoards(int $gameId): void
    {
        $size = 5;
        $allNumberCount = pow($size, 2) - 1;

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $gameNumbers = \App\Domain\Game\GameNumbers::create($size, 2);
            $all = iterator_to_array($gameNumbers->all->shuffle());
            $boarNumbers = array_slice($all, 0, $allNumberCount);

            $data[] = [
                'game_id' => $gameId,
                'numbers' => json_encode($boarNumbers),
            ];
        }
        $this->insert('boards', $data);
    }
}
