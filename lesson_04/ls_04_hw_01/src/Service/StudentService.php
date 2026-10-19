<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\StudentDto;
use App\Entity\Student;
use App\Repository\StudentRepository;

final readonly class StudentService
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function create(StudentDto $dto): void
    {
        $student = new Student($dto->fullName);
        $this->studentRepository->save($student);
    }

    public function update(Student $student, StudentDto $dto): void
    {
        $student->setFullName($dto->fullName);
        $this->studentRepository->save($student);
    }

    public function delete(Student $student): void
    {
        $this->studentRepository->remove($student);
    }

    public function getAll(): array
    {
        return $this->studentRepository->findAll();
    }
}
