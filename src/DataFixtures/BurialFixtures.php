<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Burial;

class BurialFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Burial.csv', 'r');
        $i = 0;
        
        while (!feof($csv)) 
        {
          $line = fgetcsv($csv);
    
          $burial[$i] = new Burial();
          $burial[$i]->setFirstName($line[1]);
          $burial[$i]->setLastName($line[2]);
          if ($line[3] == NULL or $line[4] == NULL or $line[5] == NULL)
          {
            // if any of the imported date fields are null, append them together and put them in the incomplete_date field
            $date = $line[3] . '-' . $line[4] . '-' . $line[5];
            echo $date;
            $burial[$i]->setIncompleteDate($date);
          } else {
            // uses the complete date fields set and turns it into a datetime object
            // $burial[$i]->setBurialDate(new \DateTime($line[3] . "/" . $line[4] . "/" . $line[5]));
          }
          $burial[$i]->setCremation($line[6]);
          $burial[$i]->setFuneralHome($line[7]);
          $burial[$i]->setApproval($line[8]);
    
    
          $manager->flush();
        }
    }
}
