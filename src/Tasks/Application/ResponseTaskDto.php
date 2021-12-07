<?php

namespace Gravatalonga\Example\Tasks\Application;

use Gravatalonga\Example\Tasks\Entity\Task;
use Spatie\DataTransferObject\DataTransferObject;

class ResponseTaskDto extends DataTransferObject
{
    public string $uuid;

    public Task $task;

    public function responseType(): string
    {
        return 'json';
    }

    public function getStatusCode(): int
    {
        return 201;
    }

    public function getBody(): string
    {
        return '{"uuid":"' . $this->uuid . '","title":"My supper task!","isDone":false,"dueAt":null}';
    }

    public function getHeaders(): array
    {
        return [];
    }
}
