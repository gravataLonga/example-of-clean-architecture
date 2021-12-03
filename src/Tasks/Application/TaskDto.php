<?php

namespace Gravatalonga\Example\Tasks\Application;

use DateTime;
use Spatie\DataTransferObject\DataTransferObject;

class TaskDto extends DataTransferObject
{
    public ?string $uuid;

    public string $title;

    public bool $isDone = false;

    public ?DateTime $dueAt = null;
}
