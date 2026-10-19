<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\StudentDto;
use App\Entity\Student;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityNotFoundException;

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

    /**
     * @throws EntityNotFoundException
     */
    public function update(Student $student, StudentDto $dto): void
    {
        $student->setFullName($dto->fullName);
        $this->studentRepository->save($student);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Student $student): void
    {
        $this->studentRepository->remove($student);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(int $id): Student
    {
        $student = $this->studentRepository->find($id);
        if ($student === null) {
            throw new EntityNotFoundException('Студент не найден');
        }

        return $student;
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
