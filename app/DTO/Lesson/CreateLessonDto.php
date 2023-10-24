<?php

namespace App\DTO\Lesson;

use App\DTO\InitializeDtoTrait;

class CreateLessonDto
{
    use InitializeDtoTrait;


    public string $lesson_title;
    public string $instructional_objective;
    public int $unit_id;
}