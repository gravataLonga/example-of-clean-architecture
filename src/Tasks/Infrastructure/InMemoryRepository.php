<?php

namespace Gravatalonga\Example\Tasks\Infrastructure;

use Gravatalonga\Example\Tasks\Application\RepositoryInterface;
use Gravatalonga\Example\Tasks\Application\TaskRepositoryDto;

class InMemoryRepository implements RepositoryInterface
{
    public array $records = [];

    public function __construct(array $records = [])
    {
        $this->records = $records;
    }

    public function create(string $uuid, TaskRepositoryDto $dto): bool
    {
        $this->records[$uuid] = $dto;
        return true;
    }

    public function find(string $uuid): ?TaskRepositoryDto
    {
        return $this->records[$uuid] ?? null;
    }

    public function update(string $uuid, TaskRepositoryDto $dto): bool
    {
        if (false === array_key_exists($uuid, $this->records)) {
            return false;
        }

        $this->records[$uuid] = $dto;
        return true;
    }

    public function toggleDone(string $uuid): bool
    {
        if (false === array_key_exists($uuid, $this->records)) {
            return false;
        }

        $this->records[$uuid]->isDone = !$this->records[$uuid]->isDone;
        return true;
    }
}