<?php

namespace Gravatalonga\Example\Tasks\Application;

use Gravatalonga\Example\Tasks\Entity\Task;
use Ramsey\Uuid\Uuid;

class CreateInteractor
{
    private OutputInteractorInterface $output;

    private RepositoryInterface $repository;

    public function __construct(OutputInteractorInterface $output, RepositoryInterface $repository)
    {
        $this->output = $output;
        $this->repository = $repository;
    }

    public function handle(RequestDto $request): ResponseTaskDto
    {
        $task = new Task($request->title);
        $taskDto = new TaskDto(
            task: $task
        );

        $uuid = Uuid::uuid4();
        $this->repository->create($uuid, $taskDto);

        return new ResponseTaskDto(uuid: $uuid, task: $task);
    }
}
