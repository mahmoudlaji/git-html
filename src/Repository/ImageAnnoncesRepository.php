<?php

namespace App\Repository;

use App\Entity\ImageAnnonces;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ImageAnnonces>
 *
 * @method ImageAnnonces|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageAnnonces|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageAnnonces[]    findAll()
 * @method ImageAnnonces[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageAnnoncesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageAnnonces::class);
    }

    public function add(ImageAnnonces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ImageAnnonces $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ImageAnnonces[] Returns an array of ImageAnnonces objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ImageAnnonces
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
