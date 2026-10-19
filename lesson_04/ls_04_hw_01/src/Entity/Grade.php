<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\GradeValue;
use App\Repository\GradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
final class Grade
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', enumType: GradeValue::class)]
    private GradeValue $value;

    #[ORM\ManyToOne(targetEntity: Student::class, inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private Student $student;

    public function __construct(Student $student, GradeValue $value)
    {
        $this->student = $student;
        $this->value = $value;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): GradeValue
    {
        return $this->value;
    }

    public function setValue(GradeValue $value): void
    {
        $this->value = $value;
    }

    public function getStudent(): Student
    {
        return $this->student;
    }
}
