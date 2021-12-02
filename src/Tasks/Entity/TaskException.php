<?php

namespace Gravatalonga\Example\Tasks\Entity;

class TaskException extends \Exception
{
    public static function titleCantBeEmpty(): self
    {
        return new self('task required to have a title');
    }
}
