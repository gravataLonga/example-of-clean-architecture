<?php

namespace Gravatalonga\Example\Tasks\Application;

interface CreatePresenterInterface
{
    public function create(): ResponseTaskDto;

    public function update(): ResponseTaskDto;

    public function delete(): ResponseTaskDto;

    public function find(): ResponseTaskDto;
}
