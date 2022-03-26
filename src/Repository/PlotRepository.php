<?php

namespace App\Repository;

use App\Entity\Plot;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getSectionsArray()
    {
        $sections = [];

        $results = $this->_em->createQueryBuilder('plot')
            ->select("p.section, max('p.plot_id')")
            ->from(Plot::class, 'p')
            ->groupBy('p.section')
            ->getQuery()
            ->getArrayResult();

        foreach ($results as $result) {
            if (!in_array($result['section'], $sections)) {
                $sections[$result['section']] = $result['section'];
            }
        }

        return $sections;
    }

    public function getSpacesArray()
    {
        $spaces = [];

        $results = $this->_em->createQueryBuilder('plot')
            ->select("p.space, max('p.plot_id')")
            ->from(Plot::class, 'p')
            ->groupBy('p.space')
            ->getQuery()
            ->getArrayResult();

        foreach ($results as $result) {
            if (!in_array($result['space'], $spaces)) {
                $spaces[$result['space']] = $result['space'];
            }
        }

        return $spaces;
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
        return $this->createQueryBuilder('a')
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
    public function findOneBySomeField($value): ?Plot
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
