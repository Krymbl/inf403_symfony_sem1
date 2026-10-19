<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Grade;
use App\Entity\Student;
use App\Enum\GradeValue;
use Symfony\Component\Validator\Constraints as Assert;


final class GradeDto
{
    public function __construct(
        public readonly Student $student,
        #[Assert\NotBlank(message: 'Значение обязательно')]
        public ?GradeValue $value = null,
    ) {
    }

    public static function fromGrade(Grade $grade): self
    {
        return new self($grade->getStudent(), $grade->getValue());
    }
}
