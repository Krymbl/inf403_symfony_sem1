<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Student;
use Symfony\Component\Validator\Constraints as Assert;

final class StudentDto
{
    #[Assert\NotBlank(message: 'Фио обязательно')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'ФИО должно содержать минимум {{ limit }} букв',
        maxMessage: 'ФИО должно содержать не больше {{ limit }} букв',
    )]
    public ?string $fullName = null;

    public static function fromStudent(Student $student): self
    {
        $self = new self();
        $self->fullName = $student->getFullName();

        return $self;
    }
}
