<?php

declare(strict_types=1);
namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
final class StudentRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function save(Student $student, bool $flush = true): void
    {
        $this->getEntityManager()->persist($student);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $student, bool $flush = true): void
    {
        $this->getEntityManager()->remove($student);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function flush(): void
    {
        $this->getEntityManager()->flush();
    }
}
