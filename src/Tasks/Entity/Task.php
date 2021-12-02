<?php

namespace Gravatalonga\Example\Tasks\Entity;

use DateTime;
use Stringable;

class Task implements Stringable
{
    private bool $done = false;

    private string $title;

    private ?DateTime $due = null;

    public function __construct(string $title)
    {
        if (empty($title)) {
            throw TaskException::titleCantBeEmpty();
        }

        $this->title = $title;
    }

    public function dueAt(DateTime $due): void
    {
        $this->due = $due;
    }

    public function isOnDue(): bool
    {
        if (empty($this->due)) {
            return false;
        }

        return new DateTime('now') >= $this->due;
    }

    public function due(): ?DateTime
    {
        return $this->due;
    }

    public function done(): void
    {
        $this->done = true;
    }

    public function isDone(): bool
    {
        return $this->done;
    }

    public function __toString()
    {
        return sprintf(
            ' [%s] %s%s',
            $this->isDone() ? 'x' : ' ',
            $this->title,
            ! empty($this->due) ? ' (Due at: ' . $this->due->format('Y-m-d H:i:s') . ')' : ''
        );
    }
}
