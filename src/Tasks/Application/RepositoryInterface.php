<?php

namespace Gravatalonga\Example\Tasks\Application;

interface RepositoryInterface
{
    public function create(string $uuid, TaskRepositoryDto $dto): bool;

    public function find(string $uuid): ?TaskRepositoryDto;

    public function update(string $uuid, TaskRepositoryDto $dto): bool;

    public function toggleDone(string $uuid): bool;
}