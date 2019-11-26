<?php
declare(strict_types=1);

namespace App\Domain\User;

final class User implements \JsonSerializable
{
    /** @var int|null */
    public $id;

    /** @var string */
    public $name;

    public function __construct(?int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
