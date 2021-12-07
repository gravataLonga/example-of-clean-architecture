<?php

namespace Tests\Unit\Tasks;

use DateTime;
use Gravatalonga\Example\Tasks\Entity\Task;
use Gravatalonga\Example\Tasks\Entity\TaskException;
use PHPUnit\Framework\TestCase;

class EntityTest extends TestCase
{
    /**
     * @test
     */
    public function is_not_done_recently_created_task()
    {
        $task = new Task('you can done this?');
        $this->assertFalse($task->isDone());
    }

    /**
     * @test
     */
    public function can_mark_done_task()
    {
        $task = new Task('you can done this?');

        $task->done();

        $this->assertTrue($task->isDone());
    }

    /**
     * @test
     */
    public function cant_create_empty_task()
    {
        $this->expectException(TaskException::class);
        $this->expectExceptionMessage('task required to have a title');

        new Task('');
    }

    /**
     * @test
     */
    public function can_add_due_date()
    {
        $task = new Task("my title");
        $task->dueAt(new DateTime("+1 day"));

        $this->assertFalse($task->isOnDue());
        $this->assertGreaterThan(new DateTime("now"), $task->due());
    }

    /**
     * @test
     */
    public function if_not_set_due_isnt_not_due()
    {
        $task = new Task("my title");

        $this->assertFalse($task->isOnDue());
        $this->assertNull($task->due());
    }

    /**
     * @test
     */
    public function can_be_overdue()
    {
        $task = new Task("my title");
        $task->dueAt(new DateTime("-1 day"));

        $this->assertTrue($task->isOnDue());
        $this->assertLessThan(new DateTime("now"), $task->due());
    }

    /**
     * @test
     */
    public function can_get_title ()
    {
        $task = new Task("my title");
        $this->assertEquals('my title', $task->title());
    }

    /**
     * @test
     */
    public function get_string()
    {
        $task = new Task("my title");
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', '2021-01-01 00:00:00');
        $task->dueAt($dateTime);

        $this->assertEquals(' [ ] my title (Due at: 2021-01-01 00:00:00)', (string)$task);
    }

    /**
     * @test
     * @dataProvider dataProviderCastToString
     */
    public function can_cast_to_any_state_to_string(string $title, bool $isDone, ?DateTime $due, string $expected)
    {
        $task = new Task($title);
        if (! empty($due)) {
            $task->dueAt($due);
        }

        if (! empty($isDone)) {
            $task->done();
        }

        $this->assertEquals($expected, (string)$task);
    }

    public function dataProviderCastToString()
    {
        return [
            [
                'testing',
                false,
                null,
                ' [ ] testing',
            ],
            [
                'abc',
                true,
                null,
                ' [x] abc',
            ],
            [
                '123',
                false,
                DateTime::createFromFormat('Y-m-d H:i:s', '2021-01-01 00:00:00'),
                ' [ ] 123 (Due at: 2021-01-01 00:00:00)',
            ],
            [
                'etc',
                true,
                DateTime::createFromFormat('Y-m-d H:i:s', '2021-01-01 00:00:00'),
                ' [x] etc (Due at: 2021-01-01 00:00:00)',
            ],
        ];
    }
}
