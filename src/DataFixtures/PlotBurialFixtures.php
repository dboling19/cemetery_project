<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\PlotFixtures;
use App\DataFixtures\BurialFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\Plot;


class PlotBurialFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(EntityManagerInterface $entityManager, PlotRepository $plot_repo, BurialRepository $burial_repo)
    {
      $this->em = $entityManager;
      $this->plot_repo = $plot_repo;
      $this->burial_repo = $burial_repo;
      // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the csv file and standardizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Plot-Burial M-M.csv', 'r');
        $i = 0;
        
        while (($line = fgetcsv($csv)) !== false)
        {
    
          $plot = $this->plot_repo->find((int)$line[1]);
          $burial = $this->burial_repo->find((int)$line[2]);
          $plot->setBurial($burial);
    
          $this->em->flush();

        }
    }

    public function getDependencies()
    {
      return [
        PlotFixtures::class,
        BurialFixtures::class,
      ];
    }
}
