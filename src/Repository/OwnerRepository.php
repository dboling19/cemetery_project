<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

  public function getOwnerNames()
  {

    $owners = [];

    $results = $this->_em->createQueryBuilder('owner')
      ->select("o.ownerFullName")
      ->from(Owner::class, 'o')
      ->getQuery()
      ->getArrayResult()
    ;

    foreach ($results as $result) {
      if (!in_array($result['ownerFullName'], $owners)) {
        $owners[$result['ownerFullName']] = $result['ownerFullName'];
      }
    }

    return $owners;

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
      ->andWhere('a.exampleField = :val')
      ->setParameter('val', $value)
      ->orderBy('a.id', 'ASC')
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
      ->andWhere('a.exampleField = :val')
      ->setParameter('val', $value)
      ->getQuery()
      ->getOneOrNullResult()
    ;
  }
  */
}
