<?php

namespace App\DTO\Topic;

use App\DTO\InitializeDtoTrait;

class CreateTopicDto
{
    use InitializeDtoTrait;


    public string $topic_title;
    public string $instructional_objectives;
    public int $unit_id;
    public int $user_id;
}