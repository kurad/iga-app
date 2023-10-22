<?php

namespace App\DTO\Subject;

use App\DTO\InitializeDtoTrait;

class UpdateSubjectDto
{
    use InitializeDtoTrait;


    public string $name;
    public int $level_id;
}