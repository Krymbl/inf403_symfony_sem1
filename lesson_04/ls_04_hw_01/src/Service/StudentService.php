<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\StudentDto;
use App\Entity\Student;
use App\Exception\Student\StudentNotFoundException;
use App\Repository\StudentRepository;

final readonly class StudentService
{
    public function __construct(
        private StudentRepository $studentRepository
    ) {
    }

    public function create(StudentDto $dto): Student
    {
        $student = new Student($dto->fullName);
        $this->studentRepository->save($student);
        return $student;
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

    /**
     * @throws StudentNotFoundException
     */
    public function get(int $id): Student
    {
        return $this->studentRepository->find($id)
            ?? throw new StudentNotFoundException();
    }

    public function getAllWithGrades(): array
    {
        return $this->studentRepository->findAllWithGrades();
    }

    public function getAll(): array
    {
        return $this->studentRepository->findAll();
    }
}
