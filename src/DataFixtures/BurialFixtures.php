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


class BurialFixtures extends Fixture
{

    public function __construct(EntityManagerInterface $entityManager, BurialRepository $burial_repo)
    {
      $this->em = $entityManager;
      $this->burial_repo = $burial_repo;
    //   $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }
  
  
    /**
     * Takes the owner import files and standardizes the input information for submission.
     * 
     * @author Daniel Boling
     */
    public function load(ObjectManager $manager): void
    {
        $csv = fopen('C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Burial.csv', 'r');
        $i = 0;
        
        while (($line = fgetcsv($csv)) !== false) 
        {
    
          $burial[$i] = new Burial();
          $burial[$i]->setId((int)$line[0]);
          $burial[$i]->setFirstName($line[1]);
          $burial[$i]->setLastName($line[2]);
          if ($line[3] == "NULL" or $line[4] == "NULL" or $line[5] == "NULL")
          {
            // if any of the imported date fields are null, append them together and put them in the incomplete_date field
            $date = sprintf('%02d', $line[3]) . '-' . sprintf('%02d', $line[4]) . '-' . sprintf('%02d', $line[5]);
            $date = str_replace(array('NULL', '00'), '', $date);
            if ($date == '--') {
              $burial[$i]->setIncDate(NULL);
            } else {
              $burial[$i]->setIncDate($date);
            }
          } else {
            // uses the complete date fields set and turns it into a datetime object
            $burial[$i]->setDate(new \DateTime((int)$line[3] . '-' . (int)$line[4] . '-' . (int)$line[5]));
          }
          if ((int)$line[6] == 1)
          {
            $burial[$i]->setCremation(true);
          } else {
            $burial[$i]->setCremation(false);
          }
          if ($line[7] == 'NULL' or $line[7] == '') {
            // if null entry or empty string, skip insert.
            $burial[$i]->setFuneralHome(NULL);
          } else {
            $burial[$i]->setFuneralHome($line[7]);
          }
          if ((int)$line[8] == 1)
          {
            $burial[$i]->setApproval(true);
          } else {
            $burial[$i]->setApproval(false);
          }
          $this->em->persist($burial[$i]);
    
          $this->em->flush();

        }
    }
}
