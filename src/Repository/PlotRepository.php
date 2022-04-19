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
  public function findAllRelated($id = null, $term = null)
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
    } elseif ($term != null) {
      // this will send the query object back to the DisplayController::display() function
      // for the pagination functionality
      return $qb
        ->andWhere('
        CONCAT(plot.section, plot.lot, plot.space) LIKE :term
        OR owner.firstName LIKE :term
        OR owner.lastName LIKE :term
        OR owner.address LIKE :term
        OR owner.city LIKE :term
        OR owner.state LIKE :term
        OR owner.phoneNum LIKE :term
        OR burial.firstName LIKE :term
        OR burial.lastName LIKE :term
        OR burial.funeralHome LIKE :term')
        ->setParameter('term', '%'.$term.'%')
      ;
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
