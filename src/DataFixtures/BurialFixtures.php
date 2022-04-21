<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\Plot;


class BurialFixtures extends Fixture implements DependentFixtureInterface
{

  public function __construct(EntityManagerInterface $entityManager, BurialRepository $burial_repo, PlotRepository $plot_repo)
  {
    $this->em = $entityManager;
    $this->burial_repo = $burial_repo;
    $this->plot_repo = $plot_repo;
  //   $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }


  /**
   * Takes the owner import files and standardizes the input information for submission.
   * 
   * @author Daniel Boling
   */
  public function load(ObjectManager $manager): void
  {
    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Burial.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
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
      $burial[$i]->setApproval(1);
      $this->em->persist($burial[$i]);
      $count += 1;
      printf("WG Burials - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    $id = $this->burial_repo->findOneBy(array(), array('id' => 'desc'))->getId();

    while (($line = fgetcsv($csv)) !== false) 
    {
      if ($line[7] != null or $line[7] != '' and $line[8] != null or $line[8] != '')
      {
        $id += 1;
        $burial[$i] = new Burial();
        $burial[$i]->setId($id);
        $burial[$i]->setFirstName($line[7]);
        $burial[$i]->setLastName($line[8]);
        if ($line[9] != null or $line[9] != '')
        {
          $date = explode('/', $line[9]);
          if (count($date) == 3) {
            if (checkdate((int)$date[0], (int)$date[1], (int)$date[2]) == true) {
              $burial[$i]->setDate(new \DateTime($line[9]));

            } else {
              // uses the complete date fields set and turns it into a datetime object
              $date = str_replace('/', '-', $line[9]);
              if ($date == '--') {
                $burial[$i]->setIncDate(NULL);
              } else {
                $burial[$i]->setIncDate($date);
              }

            }
          }
        }
        if ((int)$line[10] == 1)
        {
          $burial[$i]->setCremation(true);
        } else {
          $burial[$i]->setCremation(false);
        }
        $burial[$i]->setFuneralHome($line[11]);
        $burial[$i]->setApproval(1);
        $this->em->persist($burial[$i]);


      }
      $count += 1;
      printf("Violet Burials - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();


  }


  public function getDependencies()
  {
    return [
      PlotFixtures::class,
    ];
  }
}


// EOF
