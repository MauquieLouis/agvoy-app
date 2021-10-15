<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Region;

/**
 * @method Room|null find($id, $lockMode = null, $lockVersion = null)
 * @method Room|null findOneBy(array $criteria, array $orderBy = null)
 * @method Room[]    findAll()
 * @method Room[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }
    
    
    public function findSixLast()
    {
        return $this->createQueryBuilder('r')
            ->select('r')
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }
    
    // /**
    //  * @return Room[] Returns an array of Room objects
    //  */
    
     public function findByRegionId($value)
     {
         return $this->createQueryBuilder('r')
         ->andWhere('r.region = :val')
         ->setParameter('val', $value)
         ->orderBy('r.id', 'ASC')
         ->setMaxResults(10)
         ->getQuery()
         ->getResult()
         ;
     }
     
     public function getRoom(Region $region)
     {
         $qb = $this->createQueryBuilder("p")
         ->where(':region MEMBER OF p.region')
         ->setParameters(array('region' => $region))
         ;
         return $qb->getQuery()->getResult();
     }
     
     /*
   // Récupérer les 6 dernières Rooms ajouté pour les afficher dans la zone recherche

    // /**
    //  * @return Room[] Returns an array of Room objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Room
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
