<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\BurialRepository;
use App\Entity\Plot;
use App\Entity\Burial;

class PlotBurialFixtures extends Fixture
{

    public function __construct(EntityManagerInterface $entityManager)
    {
      $this->em = $entityManager;
    }
  
  
    /**
     * Takes the plot/burial import files and standartizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        // $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Plot-Burial M-M.csv', 'r');
        // $i = 0;
        
        // while (($line = fgetcsv($csv)) !== false)
        // {
    
        //   $plot_burial[$i] = new PlotBurial($line[1]);
        //   $plot[$i]->setBurialId($line[2]);
        //   if ((int)$line[2] == 1)
        //   {
        //     $plot[$i]->setApproval(true);
        //   } else {
        //     $plot[$i]->setApproval(false);
        //   }
        //   $this->em->persist($plot[$i]);
    
    
        //   $this->em->flush();
        // }
    }
}
