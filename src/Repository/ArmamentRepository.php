<?php

namespace App\Repository;

use App\Entity\Armament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\DocBlock\Description;

/**
 * @extends ServiceEntityRepository<Armament>
 *
 * @method Armament|null find($id, $lockMode = null, $lockVersion = null)
 * @method Armament|null findOneBy(array $criteria, array $orderBy = null)
 * @method Armament[]    findAll()
 * @method Armament[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArmamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Armament::class);
    }

    public function save(Armament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Armament $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    

    public function getPaginatedArmament($page, $limit, 
        $filters = null, 
        $mots = null, 
        $sort = null,
        $maxPrice = null,
        $minPrice = null,
        $caliber = null
        )
    {

        $query = $this->createQueryBuilder('a')
        ->select('a','c')
        ->leftjoin('a.categorie', 'c');
        

        if ($filters != null ) {
            $query->where('c IN (:cats)')
            ->setParameter('cats', $filters);
        }
        if ($mots != null ) {
            $query->andWhere('a.name like :mots')
            ->orWhere('a.description like :mots')
            ->setParameter('mots', '%'.$mots.'%');

        }
        if($sort != null){
            $query->addOrderBy('a.price', $sort);
        }
        if($maxPrice != null){
            $query->andWhere('a.price <= :maxprice')
            ->setParameter('maxprice', $maxPrice);
        }
        if($minPrice != null){
            $query->andWhere('a.price >= :minprice')
            ->setParameter('minprice', $minPrice);
        }
        if ($caliber != null ) {
            $query->andWhere('a.calibre IN (:cal)')
            ->setParameter('cal', $caliber);
        }
        $query->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit);
        

        return $query->getQuery()->getResult();

    }


   



   
    public function getTotalProduit( 
    $filters = null, 
    $mots = null, 
    $sort = null,
    $maxPrice = null,
    $minPrice = null,
    $caliber = null)
    {
        $query = $this->createQueryBuilder('a')
            ->select('COUNT(a)')
            ->leftjoin('a.categorie', 'c');
        ;
        if ($filters != null ) {
            $query->where('c IN (:cats)')
            ->setParameter('cats', $filters);
        }
        if($maxPrice != null){
            $query->andWhere('a.price <= :maxprice')
            ->setParameter('maxprice', $maxPrice);
        }
        if($sort != null){
            $query->addOrderBy('a.price', $sort);
        }
        if($minPrice != null){
            $query->andWhere('a.price >= :minprice')
            ->setParameter('minprice', $minPrice);
        }
        if ($mots != null ) {
            $query->andWhere('a.name like :mots')
            ->orWhere('a.description like :mots')
            ->setParameter('mots', '%'.$mots.'%');
        }
        if ($caliber != null ) {
            $query->andWhere('a.calibre IN (:cal)')
            ->setParameter('cal', $caliber);
        }
       
        
        return $query->getQuery()->getSingleScalarResult();
        

    }

    public function getMaxPrice()
    {
        $query = $this->createQueryBuilder('a')
        ->select('a.price')
        ->addOrderBy('a.price', 'DESC')
        ->setMaxResults(1)
    
        
        
        ;
        return $query->getQuery()->getResult();
    }





//    /**
//     * @return Armament[] Returns an array of Armament objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Armament
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
