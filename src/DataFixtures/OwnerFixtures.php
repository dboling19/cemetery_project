<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\Plot;


class OwnerFixtures extends Fixture
{

    public function __construct(EntityManagerInterface $entityManager, OwnerRepository $owner_repo)
    {
      $this->em = $entityManager;
      $this->owner_repo = $owner_repo;
      // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the owner import files and standardizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Owner.csv', 'r');
        $i = 0;
        
        while (($line = fgetcsv($csv)) !== false)
        {
    
          $owner[$i] = new Owner();
          $owner[$i]->setId((int)$line[0]);
          $full_name = explode(' ', $line[1]);
          $owner[$i]->setLastName(array_pop($full_name));
          // sets the last name first by "popping" or removing the last result from the full name array
          // this means the final "word" in the name will be the last name, and everything else 
          // (first names, middle names, surnames, etc) will be set in first_name
          $owner[$i]->setFirstName(implode(' ', $full_name));
          if ((int)$line[2] == 1)
          {
            $owner[$i]->setApproval(1);
          } else {
            $owner[$i]->setApproval(-1);
          }
          $this->em->persist($owner[$i]);
    
    
          $this->em->flush();
        }
    }
}
