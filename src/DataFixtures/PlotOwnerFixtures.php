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
    
    
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[3] != null or $line[3] != '' and $line[2] != null or $line[2] != '') or ($line[1] != null or $line[1] != ''and $line[2] != null or $line[2] != '' and $line[1]))
      {
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'West Goshen', 'section' => trim($line[6]), 'lot' => trim($line[7]), 'space' => trim($line[8])));
        $names = explode(', ', $line[1]);
        if (count($names) > 1)
        // if there are multiple owners in the primary owner field
        {
          foreach ($names as $name)
          {
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[3])));
            $owner[$i]->addPlot($plot);

          }
        } else {
          // if there is only one owner
          $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[1]), 'lastName' => trim($line[3])));
          $owner[$i]->addPlot($plot);

        }

        // shift from the primary owner field to the joint owner field.
        if ($line[2] != null or $line[2] != '')
        {
          if (strpos($line[2], '&') !== false)
          // check for several owners
          {
            $names = explode('&', $line[2]);
            // separate all owner names in an array
            foreach ($names as $name)
            {
              if (strpos($name, ',') !== false)
              // check if the name is formatted as last_name, first_name
              {
                $joint_name = explode(',', $name);
                $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($joint_name[1]), 'lastName' => trim($joint_name[0])));
                $owner[$i]->addPlot($plot);
              } else {
                // if no comma, assume it is just a first name and append it to the last name in column 3
                $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[3])));
                $owner[$i]->addPlot($plot);

              }
            }

          } else {
            // if there is only one owner - this is the simplest and most common record.
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[2]), 'lastName' => trim($line[3])));
            $owner[$i]->addPlot($plot);

          }
        }
      }
      $count += 1;
      printf("WG PO - %.2f%%\n", ($count/$file_count)*100);
      // row counter - should increment and output wether a find or not

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    $id = $this->owner_repo->findOneBy(array(), array('id' => 'desc'))->getId();
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[0] != null or $line[0] != '' and $line[1] != null or $line[1] != '') or ($line[2] != null or $line[2] != '' and $line[1] != null or $line[1] != ''))
      {
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => trim($line[3]), 'lot' => trim($line[4]), 'space' => trim($line[5])));
        if ($line[0] != null or $line[0] != '')
        {
          $names = explode('&', $line[0]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[2])));
              $owner[$i]->addPlot($plot);

            }

          } else {
            // if there is just a single owner
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[0]), 'lastName' => trim($line[2])));
            $owner[$i]->addPlot($plot);

          }
        }

        if ($line[1] != null or $line[1] != '')
        {
          $names = explode('&', $line[1]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[2])));
              $owner[$i]->addPlot($plot);

            }

          } else {
            // if there is just a single owner
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[1]), 'lastName' => trim($line[2])));
            $owner[$i]->addPlot($plot);

          }
        }
      }
      $count += 1;
      printf("Violet PO - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Oakridge Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    $id = $this->owner_repo->findOneBy(array(), array('id' => 'desc'))->getId();
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[0] != null or $line[0] != '' and $line[1] != null or $line[1] != '') or ($line[2] != null or $line[2] != '' and $line[1] != null or $line[1] != ''))
      {
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'Oakridge', 'section' => trim($line[4]), 'lot' => trim($line[5]), 'space' => trim($line[6])));
        if ($line[0] != null and $line[0] != '')
        {
          var_dump($line);
          $names = explode('&', $line[0]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[2])));
              $owner[$i]->addPlot($plot);

            }

          } else {
            // if there is just a single owner
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[0]), 'lastName' => trim($line[2])));
            $owner[$i]->addPlot($plot);

          }
        }

        if ($line[1] != null or $line[1] != '')
        // if a name/owner exists in joint-owner field
        {
          var_dump($line);
          $names = explode('&', $line[1]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name)
            {
              $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($name), 'lastName' => trim($line[2])));
              $owner[$i]->addPlot($plot);

            }

          } else {
            // if there is just a single owner
            $owner[$i] = $this->owner_repo->findOneBy(array('firstName' => trim($line[1]), 'lastName' => trim($line[2])));
            $owner[$i]->addPlot($plot);

          }
        }
      }
      $count += 1;
      printf("Oakridge PO - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();

  }

  
  public function getDependencies()
  {
    return [
      PlotFixtures::class,
      OwnerFixtures::class,
    ];
  }
}


// EOF
