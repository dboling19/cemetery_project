<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Owner::class);
  }


  /**
   * Returns all owner objects
   * 
   * @author Daniel Boling
   */
  public function findAllRelated($term = null)
  {

    $qb = $this->createQueryBuilder('owner');

    if ($term != null) {
      // this will send the query object back to the DisplayController::display() function
      // for the pagination functionality
      return $qb
        ->andWhere('
        owner.firstName LIKE :term
        OR owner.lastName LIKE :term
        OR owner.address LIKE :term
        OR owner.city LIKE :term
        OR owner.state LIKE :term
        OR owner.phoneNum LIKE :term')
        ->setParameter('term', '%'.$term.'%')
      ;
    } else {
      return $qb;
    }

  }
    

  /**
   * @throws ORMException
   * @throws OptimisticLockException
   */
  public function add(Owner $entity, bool $flush = true): void
  {
    $this->_em->persist($entity);
    if ($flush) {
      $this->_em->flush();
    }
  }

  /**
   * @throws ORMException
   * @throws OptimisticLockException
   */
  public function remove(Owner $entity, bool $flush = true): void
  {
    $this->_em->remove($entity);
    if ($flush) {
      $this->_em->flush();
    }
  }

  // /**
  //  * @return Owner[] Returns an array of Owner objects
  //  */
  /*
  public function findByExampleField($value)
  {
    return $this->createQueryBuilder('o')
      ->andWhere('o.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('o.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
    ;
  }
  */

  /*
  public function findOneBySomeField($value): ?Owner
  {
    return $this->createQueryBuilder('o')
      ->andWhere('o.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
    ;
  }
  */
}
