<?php

namespace App\Repository;

use App\Entity\ProductPriceOffer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ProductPriceOffer|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductPriceOffer|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductPriceOffer[]    findAll()
 * @method ProductPriceOffer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductPriceOfferRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductPriceOffer::class);
    }

    // /**
    //  * @return ProductPriceOffer[] Returns an array of ProductPriceOffer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductPriceOffer
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
