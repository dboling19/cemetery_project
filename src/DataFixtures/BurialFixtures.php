<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Burial;

class BurialFixtures extends Fixture
{

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
    // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }


  /**
   * Takes the burial import files and standartizes the input information for submission.
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
      $burial[$i]->setFirstName($line[1]);
      $burial[$i]->setLastName($line[2]);
      if ($line[3] == "NULL" or $line[4] == "NULL" or $line[5] == "NULL")
      {
        // if any of the imported date fields are null, append them together and put them in the incomplete_date field
        $date = $line[3] . '-' . $line[4] . '-' . $line[5];
        $date = str_replace('NULL', '', $date);
        $burial[$i]->setIncompleteDate($date);
      } else {
        // uses the complete date fields set and turns it into a datetime object
        // $date = new \DateTime($timezone = 'America/Indiana/Indianapolis');
        // $burial[$i]->setBurialDate(($date->setDate((int)$line[3], (int)$line[4], (int)$line[5])));
        $burial[$i]->setBurialDate(new \DateTime((int)$line[3] . '-' . (int)$line[4] . '-' . (int)$line[5]));
      }
      if ((int)$line[6] == 1)
      {
        $burial[$i]->setCremation(true);
      } else {
        $burial[$i]->setCremation(false);
      }
      $burial[$i]->setFuneralHome($line[7]);
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
