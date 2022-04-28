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


class OwnerFixtures extends Fixture implements DependentFixtureInterface
{

  public function __construct(EntityManagerInterface $entityManager, OwnerRepository $owner_repo, PlotRepository $plot_repo)
  {
    $this->em = $entityManager;
    $this->owner_repo = $owner_repo;
    $this->plot_repo = $plot_repo;
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
    $id = 0;
    $completed_owners = array();
    
    
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[3] != null or $line[3] != '' and $line[2] != null or $line[2] != '') or ($line[1] != null or $line[1] != ''and $line[2] != null or $line[2] != '' and $line[1]))
      {
        $names = explode(', ', $line[1]);
        if (count($names) > 1)
        // if there are multiple owners in the primary owner field
        {
          foreach ($names as $name)
          {
            if (in_array(trim($name) . trim($line[3]), $completed_owners) == false)
            // check in the local array if the owner has already been added
            {
              $id += 1;
              $owner[$i] = new Owner();
              $owner[$i]->setId($id);
              $owner[$i]->setFirstName(trim($name));
              $owner[$i]->setLastName(trim($line[3]));
              $owner[$i]->setApproval(1);
              $this->em->persist($owner[$i]);
              array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

            }
          }
        } else {
          // if there is only one owner
          if (in_array(trim($line[1]) . trim($line[3]), $completed_owners) == false)
          {
            $id += 1;
            $owner[$i] = new Owner();
            $owner[$i]->setId($id);
            $owner[$i]->setFirstName(trim($line[1]));
            $owner[$i]->setLastName(trim($line[3]));
            $owner[$i]->setApproval(1);
            $this->em->persist($owner[$i]);
            array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

          }
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
                if (in_array(trim($joint_name[1]) . trim($joint_name[0]), $completed_owners) == false)
                {
                  $id += 1;
                  $owner[$i] = new Owner();
                  $owner[$i]->setId($id);
                  $owner[$i]->setFirstName(trim($joint_name[1]));
                  $owner[$i]->setLastName(trim($joint_name[0]));
                  // this will format the names in the system with the appropriate columns
                  // by going end-to-start through the array
                  $owner[$i]->setApproval(1);
                  $this->em->persist($owner[$i]);
                  array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

                }
                

              } else {
                // if no comma, assume it is just a first name and append it to the last name in column 3
                if (in_array(trim($name) . trim($line[3]), $completed_owners) == false)
                // check in the local array if the owner has already been added
                {
                  $id += 1;
                  $owner[$i] = new Owner();
                  $owner[$i]->setId($id);
                  $owner[$i]->setFirstName(trim($name));
                  $owner[$i]->setLastName(trim($line[3]));
                  $owner[$i]->setApproval(1);
                  $this->em->persist($owner[$i]);
                  array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

                }
              }
            }

          } else {
            // if there is only one owner - this is the simplest and most common record.
            if (in_array(trim($line[2]) . trim($line[3]), $completed_owners) == false)
            // check in the local array if the owner has already been added
            {
              $id += 1;
              $owner[$i] = new Owner();
              $owner[$i]->setId($id);
              $owner[$i]->setFirstName(trim($line[2]));
              $owner[$i]->setLastName(trim($line[3]));
              $owner[$i]->setApproval(1);
              $this->em->persist($owner[$i]);
              array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

            }
          }
        }
      }
      $count += 1;
      printf("WG Owners - %.2f%%\n", ($count/$file_count)*100);
      // row counter - should increment and output wether a find or not

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    $completed_owners = array();
    
    $id = $this->owner_repo->findOneBy(array(), array('id' => 'desc'))->getId();
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[0] != null or $line[0] != '' and $line[1] != null or $line[1] != '') or ($line[2] != null or $line[2] != '' and $line[1] != null or $line[1] != ''))
      {
        if ($line[0] != null or $line[0] != '')
        {
          $names = explode('&', $line[0]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              if (in_array(trim($name) . trim($line[2]), $completed_owners) == false)
              // check in the local array if the owner has already been added
              {
                $id += 1;
                $owner[$i] = new Owner();
                $owner[$i]->setId($id);
                // ids must be manually set
                $owner[$i]->setFirstName(trim($name));
                // removes each name one at a time, end-to-start
                $owner[$i]->setLastName(trim($line[2]));
                $owner[$i]->setApproval(1);
                // m-m setting of the plot per line
                $this->em->persist($owner[$i]);
                array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

              }
            }
          } else {
            // if there is just a single owner
            if (in_array(trim($line[0]) . trim($line[2]), $completed_owners) == false)
            // check in the local array if the owner has already been added
            {
              $id += 1;
              $owner[$i] = new Owner();
              $owner[$i]->setId($id);
              $owner[$i]->setFirstName(trim($line[0]));
              $owner[$i]->setLastName(trim($line[2]));
              $owner[$i]->setApproval(1);
              $this->em->persist($owner[$i]);
              array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

            }
          }
        }

        if ($line[1] != null or $line[1] != '')
        // if a name/owner exists in joint-owner field
        {
          // if there is just a single owner
          $names = explode('&', $line[1]);
          if(count($names) > 1)
          {
            foreach ($names as $name) {
              if (in_array(trim($name) . trim($line[2]), $completed_owners) == false)
              // check in the local array if the owner has already been added
              {
                $id += 1;
                $owner[$i] = new Owner();
                $owner[$i]->setId($id);
                // ids must be manually set
                $owner[$i]->setFirstName(trim($name));
                // removes each name one at a time, end-to-start
                $owner[$i]->setLastName(trim($line[2]));
                $owner[$i]->setApproval(1);
                // m-m setting of the plot per line
                $this->em->persist($owner[$i]);
                array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

              }
            }
          } else {
            // check in the local array if the owner has already been added
            $id += 1;
            $owner[$i] = new Owner();
            $owner[$i]->setId($id);
            $owner[$i]->setFirstName(trim($line[1]));
            $owner[$i]->setLastName(trim($line[2]));
            $owner[$i]->setApproval(1);
            $this->em->persist($owner[$i]);
            array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

          }
        }
      }
      $count += 1;
      printf("Violet Owners - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();

    
    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Oakridge Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    $completed_owners = array();
    
    $id = $this->owner_repo->findOneBy(array(), array('id' => 'desc'))->getId();
    while (($line = fgetcsv($csv)) !== false)
    {
      if (($line[0] != null or $line[0] != '' and $line[1] != null or $line[1] != '') or ($line[2] != null or $line[2] != '' and $line[1] != null or $line[1] != ''))
      {
        if ($line[0] != null or $line[0] != '')
        {
          $names = explode('&', $line[0]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              if (in_array(trim($name) . trim($line[2]), $completed_owners) == false)
              // check in the local array if the owner has already been added
              {
                $id += 1;
                $owner[$i] = new Owner();
                $owner[$i]->setId($id);
                // ids must be manually set
                $owner[$i]->setFirstName(trim($name));
                // removes each name one at a time, end-to-start
                $owner[$i]->setLastName(trim($line[2]));
                $owner[$i]->setApproval(1);
                // m-m setting of the plot per line
                $this->em->persist($owner[$i]);
                array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

              }
            }
          } else {
            // if there is just a single owner
            if (in_array(trim($line[0]) . trim($line[2]), $completed_owners) == false)
            // check in the local array if the owner has already been added
            {
              $id += 1;
              $owner[$i] = new Owner();
              $owner[$i]->setId($id);
              $owner[$i]->setFirstName(trim($line[0]));
              $owner[$i]->setLastName(trim($line[2]));
              $owner[$i]->setApproval(1);
              $this->em->persist($owner[$i]);
              array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

            }
          }
        }

        if ($line[1] != null or $line[1] != '')
        // if a name/owner exists in joint-owner field
        {
          $names = explode('&', $line[1]);
          if (count($names) > 1)
          // if the formatting proves more than one first name
          {
            foreach ($names as $name) {
              if (in_array(trim($name) . trim($line[2]), $completed_owners) == false)
              // check in the local array if the owner has already been added
              {
                $id += 1;
                $owner[$i] = new Owner();
                $owner[$i]->setId($id);
                // ids must be manually set
                $owner[$i]->setFirstName(trim($name));
                // removes each name one at a time, end-to-start
                $owner[$i]->setLastName(trim($line[2]));
                $owner[$i]->setApproval(1);
                // m-m setting of the plot per line
                $this->em->persist($owner[$i]);
                array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());

              }
            }
          } else {
            // if there is just a single owner
            if (in_array(trim($line[1]) . trim($line[2]), $completed_owners) == false)
            // check in the local array if the owner has already been added
            {
              $id += 1;
              $owner[$i] = new Owner();
              $owner[$i]->setId($id);
              $owner[$i]->setFirstName(trim($line[1]));
              $owner[$i]->setLastName(trim($line[2]));
              $owner[$i]->setApproval(1);
              $this->em->persist($owner[$i]);
              array_push($completed_owners, $owner[$i]->getFirstName() . $owner[$i]->getLastName());
            }
          }
        }
      }
      $count += 1;
      printf("Oakridge Owners - %.2f%%\n", ($count/$file_count)*100);

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
