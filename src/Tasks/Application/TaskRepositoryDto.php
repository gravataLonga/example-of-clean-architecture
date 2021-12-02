<?php

namespace Gravatalonga\Example\Tasks\Application;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject;

class TaskRepositoryDto extends DataTransferObject
{
    public string $title;

    public bool $isDone = false;

    public ?DateTime $dueAt = null;
}