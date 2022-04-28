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
  public function findAllRelated($search = null)
  {
    $qb = $this->createQueryBuilder('owner');

    if ($search != null) {
      $search = explode(' ', $search);
      if (count($search) > 1)
      {
        // there are two names (first and last) separated by a space
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode(' ', $search).'%')
          ->orWhere('
            owner.firstName LIKE :first_term
            AND owner.lastName LIKE :last_term');

      } elseif (count($search) > 2) {
        // there are three names (first, middle, and last) separated by a space
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode($search).'%')
          ->orWhere('
            owner.firstName LIKE :first_term
            AND owner.lastName LIKE :last_term');

      } else {
        // this will send the query object back to the DisplayController::display() function
        // for the pagination functionality
        $search = $search[0];
        $search = str_replace(array('(', ')', '-'), '', $search);
        return $qb
          ->orWhere('
            owner.firstName LIKE :term
            OR owner.lastName LIKE :term
            OR owner.address LIKE :term
            OR owner.city LIKE :term
            OR owner.state LIKE :term
            OR owner.phoneNum LIKE :term')
          ->setParameter('term', '%'.$search.'%')
        ;
      }
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
