<?php

namespace Gravatalonga\Example\Tasks\Application;

use Spatie\DataTransferObject\DataTransferObject;

class ResponseTaskDto extends DataTransferObject
{
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
        return '{"uuid":"","title":"","isDone":false,"dueAt":null}';
    }

    public function getHeaders(): array
    {
        return [];
    }
}
