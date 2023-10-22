<?php

namespace App\DTO\Unit;

use App\DTO\InitializeDtoTrait;

class UpdateUnitDto
{
    use InitializeDtoTrait;


    public string $unit_title;
    public string $key_unit_competence;
    public int $subject_id;
}