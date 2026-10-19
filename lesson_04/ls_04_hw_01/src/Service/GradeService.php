<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\GradeDto;
use App\Entity\Grade;
use App\Repository\GradeRepository;
use Doctrine\ORM\EntityNotFoundException;

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

    /**
     * @throws EntityNotFoundException
     */
    public function update(Grade $grade, GradeDto $dto): Grade
    {
        $grade->setValue($dto->value);
        $this->gradeRepository->save($grade);
        return $grade;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function delete(Grade $grade): void
    {
        $this->gradeRepository->remove($grade);
    }

    /**
     * @throws EntityNotFoundException
     */
    public function get(int $id): Grade
    {
        $grade = $this->gradeRepository->find($id);
        if ($grade === null) {
            throw new EntityNotFoundException('Оценка не найден');
        }

        return $grade;
    }
}
