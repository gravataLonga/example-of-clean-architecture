<?php

namespace Gravatalonga\Example\Tasks\Application;

use Gravatalonga\Example\Tasks\Entity\Task;
use Spatie\DataTransferObject\DataTransferObject;

class TaskDto extends DataTransferObject
{
    public ?string $uuid = null;

    public Task $task;
}
