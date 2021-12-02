<?php

namespace Tests\Unit\Tasks;

use Gravatalonga\Example\Tasks\Application\TaskRepositoryDto;
use Gravatalonga\Example\Tasks\Entity\Task;
use Gravatalonga\Example\Tasks\Infrastructure\InMemoryRepository;
use PHPUnit\Framework\TestCase;

class InMemoryRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_created_on_repository ()
    {
        $repository = new InMemoryRepository();
        $taskTransferredDataObject = new TaskRepositoryDto(
            title: "My title",
            isDone: false
        );

        $result = $repository->create('1234567', $taskTransferredDataObject);

        $this->assertTrue($result);
        $this->assertNotEmpty($repository->records);
    }

    /**
     * @test
     */
    public function it_can_find_by_uuid ()
    {
        $taskTransferredDataObject = new TaskRepositoryDto(
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository(['0001' => $taskTransferredDataObject]);

        $dto = $repository->find('0001');

        $this->assertNotEmpty($dto);
        $this->assertEquals('My title', $dto->title);
        $this->assertEquals(false, $dto->isDone);
    }
    
    /**
     * @test
     */
    public function if_cant_find_return_null ()
    {
        $repository = new InMemoryRepository();

        $dto = $repository->find('0001');

        $this->assertNull($dto);
    }

    /**
     * @test
     */
    public function can_update_task ()
    {
        $taskTransferredDataObject = new TaskRepositoryDto(
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository(['0001' => $taskTransferredDataObject]);

        $result = $repository->update('0001', new TaskRepositoryDto(
            title: 'My updated title'
        ));

        $this->assertTrue($result);
        $this->assertEquals('My updated title', $repository->records['0001']->title);
    }

    /**
     * @test
     */
    public function cant_update_if_cant_find ()
    {
        $repository = new InMemoryRepository();

        $result = $repository->update('0001', new TaskRepositoryDto(
            title: 'My updated title'
        ));

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function mark_done_task ()
    {
        $taskTransferredDataObject = new TaskRepositoryDto(
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository(['0001' => $taskTransferredDataObject]);

        $result = $repository->toggleDone('0001');

        $this->assertTrue($result);
        $this->assertTrue($repository->records['0001']->isDone);
    }

    /**
     * @test
     */
    public function cant_toggle_done_if_cant_found ()
    {
        $repository = new InMemoryRepository();

        $result = $repository->toggleDone('0001');

        $this->assertFalse($result);
    }
}