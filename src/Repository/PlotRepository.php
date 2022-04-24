<?php

namespace App\Repository;

use App\Entity\Plot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use App\Repository\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Plot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Plot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Plot[]    findAll()
 * @method Plot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlotRepository extends ServiceEntityRepository
{
  public function __construct(ManagerRegistry $registry)
  {
    parent::__construct($registry, Plot::class);
  }


  /**
   * Returns all plot objects, and joins all burials and owners that are related to the plot.
   * 
   * @author Daniel Boling
   */
  public function findAllRelated($id = null, $search = null)
  {
    $qb = $this->createQueryBuilder('plot');
      
    $qb->leftJoin('plot.burial', 'burial')
      ->leftJoin('plot.owner', 'owner')
      ->addSelect('plot', 'burial', 'owner')
    ;

    if ($id != null) {
      // used specifically for ./src/Controller/DisplayController.php::details()
      // for finding one plot with related entities.
      return $qb
        ->andWhere('plot.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getOneOrNullResult()
      ;
    } elseif ($search != null) {
      $search = explode(' ', $search);
      if (count($search) > 1)
      {
        // there are two names (first and last) separated by a space
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode(' ', $search).'%')
          ->orWhere('
            owner.firstName LIKE :first_term
            AND owner.lastName LIKE :last_term')
          ->orWhere('
            burial.firstName LIKE :first_term
            AND burial.lastName LIKE :last_term');
  
      } elseif (count($search) > 2) {
        // there are three names (first, middle, and last) separated by a space
        return $qb
          ->setParameter('last_term', '%'.array_pop($search).'%')
          ->setParameter('first_term', '%'.implode($search).'%')
          ->orWhere('
            burial.firstName LIKE :first_term
            AND burial.lastName LIKE :last_term');

      } else {
        $search = $search[0];
        // this will send the query object back to the DisplayController::display() function
        // for the pagination functionality
        return $qb
          ->orWhere('plot.cemetery LIKE :term')
          ->orWhere('CONCAT(plot.section, plot.lot, plot.space) LIKE :term')
          ->orWhere('owner.firstName LIKE :term')
          ->orWhere('owner.lastName LIKE :term')
          ->orWhere('burial.firstName LIKE :term')
          ->orWhere('burial.lastName LIKE :term')
          ->setParameter('term', '%'.$search.'%')
        ;
      }
    } else {
      // if id and query are both null
      return $qb;

    }

  }


  /**
   * @throws ORMException
   * @throws OptimisticLockException
   */
  public function add(Plot $entity, bool $flush = true): void
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
  public function remove(Plot $entity, bool $flush = true): void
  {
    $this->_em->remove($entity);
    if ($flush) {
      $this->_em->flush();
    }
  }

  // /**
  //  * @return Plot[] Returns an array of Plot objects
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
  public function findOneBySomeField($value): ?Plot
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
