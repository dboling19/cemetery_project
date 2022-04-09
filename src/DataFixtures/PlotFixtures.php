<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BurialRepository;
use App\Entity\Burial;
use App\Entity\Plot;

class PlotFixtures extends Fixture
{

    public function __construct(EntityManagerInterface $entityManager, BurialRepository $burial_repo)
    {
      $this->em = $entityManager;
      $this->burial_repo = $burial_repo;
      // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the plot import files and standartizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Plot.csv', 'r');
        $i = 0;
        
        while (($line = fgetcsv($csv)) !== false)
        {
    
          $plot[$i] = new Plot();
          $plot[$i]->setCemetery($line[1]);
          $plot[$i]->setSection($line[2]);
          $plot[$i]->setLot($line[3]);
          $plot[$i]->setSpace($line[4]);
          $plot[$i]->setNotes($line[5]);
          if ((int)$line[6] == 1)
          {
            $plot[$i]->setApproval(true);
          } else {
            $plot[$i]->setApproval(false);
          }
          if ($line[7] != NULL or $line[7] != '')
          {
            $burial = $this->burial_repo->find((int)$line[7]);
            var_dump($burial);
            $plot[$i]->setBurial($burial);
          }
          $this->em->persist($plot[$i]);
    
    
          $this->em->flush();
        }
    }
}
