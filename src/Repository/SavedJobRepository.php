<?php

namespace App\Repository;

use App\Entity\SavedJob;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SavedJob>
 *
 * @method SavedJob|null find($id, $lockMode = null, $lockVersion = null)
 * @method SavedJob|null findOneBy(array $criteria, array $orderBy = null)
 * @method SavedJob[]    findAll()
 * @method SavedJob[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SavedJobRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SavedJob::class);
    }

    public function save(SavedJob $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SavedJob $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Get the saved jobs for a specific user based on their user ID.
     *
     * @param int $userId The ID of the user
     * @return array|null The saved jobs for the user
     */
    public function findSavedJobsByUserId(string $userId): array
    {
        return $this->createQueryBuilder('sj')
            ->join('sj.user', 'u')
            ->where('u.id = :userId')
            ->setParameter('userId', $userId)
            ->getQuery()
            ->getResult();
    }
    //    /**
    //     * @return SavedJob[] Returns an array of SavedJob objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?SavedJob
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
