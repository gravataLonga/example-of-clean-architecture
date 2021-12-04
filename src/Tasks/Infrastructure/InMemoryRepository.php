<?php

namespace Gravatalonga\Example\Tasks\Infrastructure;

use Gravatalonga\Example\Tasks\Application\RepositoryInterface;
use Gravatalonga\Example\Tasks\Application\TaskDto;

class InMemoryRepository implements RepositoryInterface
{
    /**
     * @var array<string, TaskDto>
     */
    public array $records = [];

    /**
     * @param array<string, TaskDto> $records
     */
    public function __construct(array $records = [])
    {
        $this->records = $records;
    }

    public function create(string $uuid, TaskDto $dto): bool
    {
        $dto->uuid = $uuid;
        $this->records[] = $dto;

        return true;
    }

    public function find(string $uuid): ?TaskDto
    {
        $record = array_filter($this->records, function ($item) use ($uuid) {
            return $item->uuid === $uuid;
        });

        if (empty($record)) {
            return null;
        }

        return $record[0];
    }

    public function paginate(int $offset, int $limit): array
    {
        return array_slice($this->records, $offset, $limit);
    }

    public function update(string $uuid, TaskDto $dto): bool
    {
        if (empty($this->find($uuid))) {
            return false;
        }

        $this->records = array_map(function ($item) use ($uuid, $dto) {
            if ($item->uuid !== $uuid) {
                return $item;
            }

            return $dto;
        }, $this->records);

        return true;
    }

    public function toggleDone(string $uuid): bool
    {
        $dto = $this->find($uuid);
        if (empty($dto)) {
            return false;
        }

        $dto->task->done();

        return $this->update($uuid, $dto);
    }

    public function destroy(string $uuid): bool
    {
        if ($this->find($uuid) === null) {
            return false;
        }

        $this->records = array_filter($this->records, function ($item) use ($uuid) {
            return $uuid !== $item->uuid;
        });

        return true;
    }
}
