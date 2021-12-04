<?php

namespace Tests\Unit\Tasks;

use Gravatalonga\Example\Tasks\Application\TaskDto;
use Gravatalonga\Example\Tasks\Entity\Task;
use Gravatalonga\Example\Tasks\Infrastructure\InMemoryRepository;
use PHPUnit\Framework\TestCase;

class InMemoryRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_created_on_repository()
    {
        $repository = new InMemoryRepository();
        $task = new Task("My title");
        $taskTransferredDataObject = new TaskDto(
            task: $task
        );

        $result = $repository->create('1234567', $taskTransferredDataObject);

        $this->assertTrue($result);
        $this->assertNotEmpty($repository->records);
    }

    /**
     * @test
     */
    public function it_can_find_by_uuid()
    {
        $task = new Task("My title");
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            task: $task
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $dto = $repository->find('0001');

        $this->assertNotEmpty($dto);
        $this->assertEquals(' [ ] My title', (string)$dto->task);
    }
    
    /**
     * @test
     */
    public function if_cant_find_return_null()
    {
        $repository = new InMemoryRepository();

        $dto = $repository->find('0001');

        $this->assertNull($dto);
    }

    /**
     * @test
     */
    public function can_update_task()
    {
        $task = new Task("My title");
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            task: $task
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->update('0001', new TaskDto(
            task: new Task('My updated title')
        ));

        $this->assertTrue($result);
        $this->assertEquals(' [ ] My updated title', (string)$repository->records[0]->task);
    }

    /**
     * @test
     */
    public function cant_update_if_cant_find()
    {
        $repository = new InMemoryRepository();

        $result = $repository->update('0001', new TaskDto(
            task: new Task('my other title')
        ));

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function mark_done_task()
    {
        $task = new Task("My title");
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            task: $task
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->toggleDone('0001');

        $this->assertTrue($result);
        $this->assertTrue($repository->records[0]->task->isDone());
    }

    /**
     * @test
     */
    public function cant_toggle_done_if_cant_found()
    {
        $repository = new InMemoryRepository();

        $result = $repository->toggleDone('0001');

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function can_delete_task()
    {
        $task = new Task("My title");
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            task: $task
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->destroy('0001');

        $this->assertTrue($result);
        $this->assertEmpty($repository->records);
    }

    /**
     * @test
     */
    public function if_record_cant_be_found_return_false()
    {
        $repository = new InMemoryRepository();

        $result = $repository->destroy('0001');

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function can_list_all_with_pagination()
    {
        $taskTransferredDataObjectOne = new TaskDto(
            uuid: '0001',
            task: new Task('My title One')
        );
        $taskTransferredDataObjectTwo = new TaskDto(
            uuid: '0002',
            task: new Task('My title Two')
        );
        $repository = new InMemoryRepository([
            $taskTransferredDataObjectOne,
            $taskTransferredDataObjectTwo,
        ]);

        $page1 = $repository->paginate(0, 1);
        $page2 = $repository->paginate(1, 1);
        $page3 = $repository->paginate(2, 1);

        $this->assertNotEmpty($page1);
        $this->assertNotEmpty($page2);
        $this->assertEmpty($page3);
        $this->assertInstanceOf(TaskDto::class, $page1[0]);
        $this->assertInstanceOf(TaskDto::class, $page2[0]);
    }
}
