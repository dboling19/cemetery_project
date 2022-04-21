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
    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Owner.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
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
      $count += 1;
      printf("WG Owners - %.2f%%\n", ($count/$file_count)*100);

    }

  //   $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
  //   $csv = fopen($filename, 'r');
  //   $file_count = count(file($filename));
  //   $count = 0;
  //   $i = 0;
    
  //   $id = $this->owner_repo->findOneBy(array(), array('id' => 'desc'))->getId();
  //   while (($line = fgetcsv($csv)) !== false)
  //   { 
  //     if (strpos($line[0], '&') !== false)
  //     // if the formatting proves more than one first name
  //     {
  //       $names = explode(' & ', $line[0]);
  //       foreach ($names as $name) {
  //         $id += 1;
  //         $owner[$i] = new Owner();
  //         $owner[$i]->setId($id);
  //         // ids must be manually set
  //         $owner[$i]->setFirstName(array_pop($names));
  //         // removes each name one at a time, end-to-start
  //         $owner[$i]->setLastName($line[2]);
  //         $owner[$i]->setApproval(1);
  //         $owner[$i]->addPlot($this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => $line[3], 'lot' => $line[4], 'space' => $line[5])));
  //         // m-m setting of the plot per line
  //         $this->em->persist($owner[$i]);
  //       }
  //     } else {
  //       // if there is just a single owner
  //       $id += 1;
  //       $owner[$i] = new Owner();
  //       $owner[$i]->setId($id);
  //       $owner[$i]->setFirstName($line[0]);
  //       $owner[$i]->setLastName($line[2]);
  //       $owner[$i]->setApproval(1);
  //       $owner[$i]->addPlot($this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => $line[3], 'lot' => $line[4], 'space' => $line[5])));
  //       $this->em->persist($owner[$i]);
  //     }

  //     if (isset($line[1]))
  //     // if a name/owner exists in joint-owner field
  //     {
  //       $id += 1;
  //       $owner[$i] = new Owner();
  //       $owner[$i]->setId($id);
  //       $owner[$i]->setFirstName($line[1]);
  //       $owner[$i]->setLastName($line[2]);
  //       $owner[$i]->setApproval(1);
  //       $owner[$i]->addPlot($this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => $line[3], 'lot' => $line[4], 'space' => $line[5])));
  //       $this->em->persist($owner[$i]);
  //     }
  //     $this->em->flush();
  //     $count += 1;
  //     printf("Violet Owners - %.2f%%\n", ($count/$file_count)*100);

  //   }

  }

  
  public function getDependencies()
  {
    return [
      PlotFixtures::class,
    ];
  }
}


// EOF
