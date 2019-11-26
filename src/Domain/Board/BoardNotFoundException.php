<?php
declare(strict_types=1);

namespace App\Domain\Board;

use App\Domain\DomainException\DomainRecordNotFoundException;

final class BoardNotFoundException extends DomainRecordNotFoundException
{
    public $message = 'The board you requested does not exist.';
}
