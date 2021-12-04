<?php

namespace Tests\Integration\Task;

use Gravatalonga\Example\Tasks\Application\CreateInteractor;
use Gravatalonga\Example\Tasks\Application\RequestDto;
use Gravatalonga\Example\Tasks\Application\ResponseTaskDto;
use Gravatalonga\Example\Tasks\Infrastructure\InMemoryRepository;
use Gravatalonga\Example\Tasks\Infrastructure\JsonOutputInteractor;
use PHPUnit\Framework\TestCase;

class CreateInteractorTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_create_task()
    {
        $outputInteractor = new JsonOutputInteractor();
        $repository = new InMemoryRepository();
        $requestTaskDto = new RequestDto(
            title: 'My supper task!'
        );

        $interactor = new CreateInteractor($outputInteractor, $repository);

        $responseTaskDto = $interactor->handle($requestTaskDto);

        $this->assertNotEmpty($responseTaskDto);
        $this->assertInstanceOf(ResponseTaskDto::class, $responseTaskDto);
        $this->assertEquals('json', $responseTaskDto->responseType());
        $this->assertEquals(201, $responseTaskDto->getStatusCode());
        $this->assertEquals('{"uuid":"","title":"","isDone":false,"dueAt":null}', $responseTaskDto->getBody());
        $this->assertEquals([], $responseTaskDto->getHeaders());
        $this->assertNotEmpty($repository->records);
        $this->assertCount(1, $repository->records);
    }
}
