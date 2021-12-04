<?php

namespace Gravatalonga\Example\Tasks\Application;

use Spatie\DataTransferObject\DataTransferObject;

class RequestDto extends DataTransferObject
{
    public string $title;
}
