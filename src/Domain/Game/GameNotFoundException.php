<?php
declare(strict_types=1);

namespace App\Domain\Game;

use App\Domain\DomainException\DomainRecordNotFoundException;

final class GameNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The game you requested does not exist.';
}
