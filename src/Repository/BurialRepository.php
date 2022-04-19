<?php

namespace App\Repository;

use App\Entity\Burial;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Burial|null find($id, $lockMode = null, $lockVersion = null)
 * @method Burial|null findOneBy(array $criteria, array $orderBy = null)
 * @method Burial[]    findAll()
 * @method Burial[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BurialRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Burial::class);
  }

  /**
   * Returns all burial objects
   * 
   * @author Daniel Boling
   */
  public function findAllRelated($term = null)
  {

    $qb = $this->createQueryBuilder('burial');

    if ($term != null) {
      // this will send the query object back to the DisplayController::display() function
      // for the pagination functionality
      return $qb
        ->andWhere('
        burial.firstName LIKE :term
        OR burial.lastName LIKE :term
        OR burial.date LIKE :term
        OR burial.funeralHome LIKE :term
        OR burial.incDate LIKE :term')
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
  public function add(Burial $entity, bool $flush = true): void
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
  public function remove(Burial $entity, bool $flush = true): void
  {
    $this->_em->remove($entity);
    if ($flush) {
      $this->_em->flush();
    }
  }

  // /**
  //  * @return Burial[] Returns an array of Burial objects
  //  */
  /*
  public function findByExampleField($value)
  {
    return $this->createQueryBuilder('b')
      ->andWhere('b.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('b.id', 'ASC')
      ->setMaxResults(10)
      ->getQuery()
      ->getResult()
    ;
  }
  */

  /*
  public function findOneBySomeField($value): ?Burial
  {
    return $this->createQueryBuilder('b')
      ->andWhere('b.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
    ;
  }
  */
}
