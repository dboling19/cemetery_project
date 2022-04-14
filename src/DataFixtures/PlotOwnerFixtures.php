<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\PlotFixtures;
use App\DataFixtures\OwnerFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\Plot;


class PlotOwnerFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(EntityManagerInterface $entityManager, PlotRepository $plot_repo, OwnerRepository $owner_repo)
    {
      $this->em = $entityManager;
      $this->plot_repo = $plot_repo;
      $this->owner_repo = $owner_repo;
      // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the csv file and standardizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Plot-Owner M-M.csv', 'r');
        $i = 0;
        
        while (($line = fgetcsv($csv)) !== false)
        {
    
          $plot = $this->plot_repo->find((int)$line[2]);
          $owner = $this->owner_repo->find((int)$line[1]);
          if ($owner == null) {
            var_dump($owner);
            echo $line[0];
          }
          $plot->addOwner($owner);
    
          $this->em->flush();

        }
    }

    public function getDependencies()
    {
      return [
        PlotFixtures::class,
        OwnerFixtures::class,
      ];
    }
}
