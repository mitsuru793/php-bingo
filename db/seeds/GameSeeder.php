<?php


use Phinx\Seed\AbstractSeed;

class GameSeeder extends AbstractSeed
{
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
        $size = 5;

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $gameNumbers = \App\Domain\Game\GameNumbers::create($size, 2);
            $hitCount = random_int(0, count($gameNumbers->all));
            rangeMap(1, $hitCount, function (int $n) use ($gameNumbers) {
                $gameNumbers->drawLots();
            });

            $data[] = [
                'numbers' => json_encode($gameNumbers),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];
        }

        $this->insert('games', $data);
    }
}
