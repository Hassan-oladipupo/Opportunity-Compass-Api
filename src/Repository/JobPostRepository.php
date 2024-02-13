<?php

namespace App\Repository;

use App\Entity\JobPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<JobPost>
 *
 * @method JobPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method JobPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method JobPost[]    findAll()
 * @method JobPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JobPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, JobPost::class);
    }

    public function save(JobPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(JobPost $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByCriteria(array $criteria): array
    {
        $queryBuilder = $this->createQueryBuilder('jp');



        if (isset($criteria['keyword'])) {
            $queryBuilder->andWhere('jp.jobTitle LIKE :keyword OR jp.jobDescription LIKE :keyword')
                ->setParameter('keyword', '%' . $criteria['keyword'] . '%');
        }


        if (isset($criteria['jobTitle'])) {
            $queryBuilder->andWhere('jp.jobTitle LIKE :jobTitle')
                ->setParameter('jobTitle', '%' . $criteria['jobTitle'] . '%');
        }

        if (isset($criteria['location'])) {
            $queryBuilder->andWhere('jp.jobLocation = :location')
                ->setParameter('location', $criteria['location']);
        }

        if (isset($criteria['jobRequirement'])) {
            $queryBuilder->andWhere('jp.jobRequirement = :jobRequirement')
                ->setParameter('jobRequirement', $criteria['jobRequirement']);
        }

        if (isset($criteria['category'])) {
            $queryBuilder->andWhere('jp.jobCategory = :category')
                ->setParameter('category', $criteria['category']);
        }

        if (isset($criteria['createdate'])) {
            $queryBuilder->andWhere('jp.createdate = :createdate')
                ->setParameter('createdDate', $criteria['createdate']);
        }


        return $queryBuilder->getQuery()->getResult();
    }




    //    /**
    //     * @return JobPost[] Returns an array of Comment objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('c.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Comment
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
