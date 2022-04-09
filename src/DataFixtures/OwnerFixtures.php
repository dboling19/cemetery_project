<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Owner;

class OwnerFixtures extends Fixture
{

    public function __construct(EntityManagerInterface $entityManager)
    {
      $this->em = $entityManager;
      // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the owner import files and standartizes the input information for submission.
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
          $full_name = explode(' ', $line[1]);
          $owner[$i]->setLastName(array_pop($full_name));
          // sets the last name first by "popping" or removing the last result from the full name array
          // this means the final "word" in the name will be the last name, and everything else 
          // (first names, middle names, surnames, etc) will be set in first_name
          $owner[$i]->setFirstName(implode(' ', $full_name));
          if ((int)$line[2] == 1)
          {
            $owner[$i]->setApproval(true);
          } else {
            $owner[$i]->setApproval(false);
          }
          $this->em->persist($owner[$i]);
    
    
          $this->em->flush();
        }
    }
}
