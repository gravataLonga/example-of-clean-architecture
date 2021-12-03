<?php

namespace Tests\Unit\Tasks;

use Gravatalonga\Example\Tasks\Application\TaskDto;
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
        $taskTransferredDataObject = new TaskDto(
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
    public function it_can_find_by_uuid()
    {
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $dto = $repository->find('0001');

        $this->assertNotEmpty($dto);
        $this->assertEquals('My title', $dto->title);
        $this->assertEquals(false, $dto->isDone);
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
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->update('0001', new TaskDto(
            title: 'My updated title'
        ));

        $this->assertTrue($result);
        $this->assertEquals('My updated title', $repository->records[0]->title);
    }

    /**
     * @test
     */
    public function cant_update_if_cant_find()
    {
        $repository = new InMemoryRepository();

        $result = $repository->update('0001', new TaskDto(
            title: 'My updated title'
        ));

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function mark_done_task()
    {
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->toggleDone('0001');

        $this->assertTrue($result);
        $this->assertTrue($repository->records[0]->isDone);
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
    public function can_delete_task ()
    {
        $taskTransferredDataObject = new TaskDto(
            uuid: '0001',
            title: "My title",
            isDone: false
        );
        $repository = new InMemoryRepository([$taskTransferredDataObject]);

        $result = $repository->destroy('0001');

        $this->assertTrue($result);
        $this->assertEmpty($repository->records);
    }

    /**
     * @test
     */
    public function if_record_cant_be_found_return_false ()
    {
        $repository = new InMemoryRepository();

        $result = $repository->destroy('0001');

        $this->assertFalse($result);
    }

    /**
     * @test
     */
    public function can_list_all_with_pagination ()
    {
        $taskTransferredDataObjectOne = new TaskDto(
            uuid: '0001',
            title: "My title One",
            isDone: false
        );
        $taskTransferredDataObjectTwo = new TaskDto(
            uuid: '0002',
            title: "My title Two",
            isDone: false
        );
        $repository = new InMemoryRepository([
            $taskTransferredDataObjectOne,
            $taskTransferredDataObjectTwo
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
