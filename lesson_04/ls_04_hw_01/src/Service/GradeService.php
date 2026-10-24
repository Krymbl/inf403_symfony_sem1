<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\GradeDto;
use App\Entity\Grade;
use App\Exception\Grade\GradeNotFoundException;
use App\Repository\GradeRepository;

final readonly class GradeService
{
    public function __construct(
        private GradeRepository $gradeRepository
    ) {
    }

    public function create(GradeDto $dto): Grade
    {
        $grade = new Grade($dto->student, $dto->value);
        $this->gradeRepository->save($grade);
        return $grade;
    }

    public function update(Grade $grade, GradeDto $dto): Grade
    {
        $grade->setValue($dto->value);
        $this->gradeRepository->save($grade);
        return $grade;
    }

    public function delete(Grade $grade): void
    {
        $this->gradeRepository->remove($grade);
    }

    /**
     * @throws GradeNotFoundException
     */
    public function get(int $id): Grade
    {
        return $this->gradeRepository->find($id)
            ?? throw new GradeNotFoundException();
    }
}
