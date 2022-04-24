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
    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    $id = 0;
    
    while (($line = fgetcsv($csv)) !== false) 
    {
      if ($line[11] != null or $line[11] != '' and $line[10] != null or $line[10] != '')
      {
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'West Goshen', 'section' => trim($line[6]), 'lot' => trim($line[7]), 'space' => trim($line[8])));
        $id += 1;
        $burial[$i] = new Burial();
        $burial[$i]->setId($id);
        $burial[$i]->setFirstName(trim($line[11]));
        $burial[$i]->setLastName(trim($line[10]));
        if ((checkdate((int)$line[12], (int)$line[13], (int)$line[14]) == false))
        // check if the three date fields can be made into a date
        {
          $date = sprintf('%02d', trim($line[12])) . '/' . sprintf('%02d', trim($line[13])) . '/' . sprintf('%02d', trim($line[14]));
          // if dates are formatted like 5/7/2001, this will correct them to 05/07/2001 for the script and readability
          $date = str_replace(array('NULL', '00'), '', $date);
          if ($date == '//') {
            $burial[$i]->setIncDate(NULL);
          } else {
            $burial[$i]->setIncDate($date);
          }
        } else {
          // uses the complete date fields set and turns it into a datetime object
          $date = sprintf('%02d', trim($line[12])) . '/' . sprintf('%02d', trim($line[13])) . '/' . sprintf('%02d', trim($line[14]));
          // if dates are formatted like 5/7/2001, this will correct them to 05/07/2001 for the script and readability
          $burial[$i]->setDate(new \DateTime($date));
        }
        if ((int)$line[15] == 1)
        {
          $burial[$i]->setCremation(true);
        } else {
          $burial[$i]->setCremation(false);
        }
        if ($line[16] == 'NULL' or $line[16] == '') {
          // if null entry or empty string, skip insert.
          $burial[$i]->setFuneralHome(NULL);
        } else {
          $burial[$i]->setFuneralHome(trim($line[16]));
        }
        $burial[$i]->setApproval(1);
        $burial[$i]->setPlot($plot);
        $this->em->persist($burial[$i]);
      }
      $count += 1;
      printf("WG Burials - %.2f%%\n", ($count/$file_count)*100);
      // row counter - should increment and output wether a find or not

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
        // formatted like 01/30/2001
        {
          $date = explode('/', $line[9]);
          if (count($date) == 3) {
            if (checkdate((int)$date[0], (int)$date[1], (int)$date[2]) == true) {
              $burial[$i]->setDate(new \DateTime($line[9]));

            } else {
              // uses the complete date fields set and turns it into a datetime object
              $date = implode($date);
              if ($date == '//') {
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
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => trim($line[3]), 'lot' => trim($line[4]), 'space' => trim($line[5])));
        $burial[$i]->setPlot($plot);
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
