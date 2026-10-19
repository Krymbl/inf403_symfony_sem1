<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Grade;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Grade>
 */
final class GradeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Grade::class);
    }

    public function save(Grade $grade, bool $flush = true): void
    {
        $this->getEntityManager()->persist($grade);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Grade $grade, bool $flush = true): void
    {
        $this->getEntityManager()->remove($grade);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
