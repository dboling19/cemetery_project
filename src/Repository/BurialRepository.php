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
  public function findAllRelated($search = null)
  {

    $qb = $this->createQueryBuilder('burial');

    if ($search != null) {
      if (count(explode(' ', $search)) >= 3)
      {
        // there are three names (first, middle, and last) separated by a space
        $search = explode(' ', $search);
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode(' ', $search).'%')
          ->orWhere('
            burial.firstName LIKE :first_term
            AND burial.lastName LIKE :last_term');

      } elseif (count(explode(' ', $search)) == 2) {
        // there there are only 2 names, first and last
        $search = explode(' ', $search);
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode($search).'%')
          ->orWhere('
            burial.firstName LIKE :first_term
            AND burial.lastName LIKE :last_term');

      } else {
        // there is only a first name
        // this will send the query object back to the DisplayController::display() function
        // for the pagination functionality
        if (count(explode('/', $search)) == 3) {
          $date = explode('/', $search);
          $date = ($date[2].'-'.$date[0].'-'.$date[1]);
          $qb->setParameter('date', $date);
          $qb->orWhere('burial.date LIKE :date');

        }
        return $qb
          ->orWhere('
            burial.firstName LIKE :term
            OR burial.lastName LIKE :term
            OR burial.funeralHome LIKE :term
            OR burial.incDate LIKE :term')
          ->setParameter('term', '%'.$search.'%');

      }
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
