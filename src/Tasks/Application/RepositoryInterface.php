<?php

namespace Gravatalonga\Example\Tasks\Application;

interface RepositoryInterface
{
    public function create(string $uuid, TaskDto $dto): bool;

    public function find(string $uuid): ?TaskDto;

    public function paginate(int $offset, int $limit): array;

    public function update(string $uuid, TaskDto $dto): bool;

    public function toggleDone(string $uuid): bool;

    public function destroy(string $uuid): bool;

}
