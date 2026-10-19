<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Grade;
use App\Entity\Student;
use App\Enum\GradeValue;
use Symfony\Component\Validator\Constraints as Assert;


final class GradeDto
{
    #[Assert\NotBlank(message: 'Студент обязателен')]
    public ?Student $student = null;

    #[Assert\NotBlank(message: 'Значение обязательно')]
    public ?GradeValue $value = null;

    public static function fromGrade(Grade $grade): GradeDto
    {
        $self = new self();
        $self->student = $grade->getStudent();
        $self->value = $grade->getValue();

        return $self;
    }
}
