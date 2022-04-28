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


class PlotFixtures extends Fixture
{

  public function __construct(EntityManagerInterface $entityManager, PlotRepository $plot_repo)
  {
    $this->em = $entityManager;
    $this->plot_repo = $plot_repo;
    // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }


  /**
   * Takes the csv file and standardizes the input information for submission.
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
      $id += 1;
      $plot[$i] = new Plot();
      $plot[$i]->setId($id);
      $plot[$i]->setCemetery('West Goshen');
      $plot[$i]->setSection(trim($line[6]));
      $plot[$i]->setLot(trim($line[7]));
      $plot[$i]->setSpace(trim($line[8]));
      $plot[$i]->setNotes(trim($line[17]));
      $plot[$i]->setApproval(1);
      $this->em->persist($plot[$i]);

      $count += 1;
      printf("WG Plots - %.2f%%\n", ($count/$file_count)*100);
      // row counter - should increment and output wether a find or not

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    $id = $this->plot_repo->findOneBy(array(), array('id' => 'desc'))->getId();

    while (($line = fgetcsv($csv)) !== false)
    {
      $id += 1;
      $plot[$i] = new Plot();
      $plot[$i]->setId($id);
      $plot[$i]->setCemetery("Violet");
      $plot[$i]->setSection($line[3]);
      $plot[$i]->setLot($line[4]);
      $plot[$i]->setSpace($line[5]);
      $plot[$i]->setNotes($line[6]);
      $plot[$i]->setApproval(1);
      $this->em->persist($plot[$i]);

      $count += 1;
      printf("Violet Plots - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Oakridge Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    $id = $this->plot_repo->findOneBy(array(), array('id' => 'desc'))->getId();

    while (($line = fgetcsv($csv)) !== false)
    {
      $id += 1;
      $plot[$i] = new Plot();
      $plot[$i]->setId($id);
      $plot[$i]->setCemetery("Oakridge");
      $plot[$i]->setSection($line[4]);
      $plot[$i]->setLot($line[5]);
      $plot[$i]->setSpace($line[6]);
      $plot[$i]->setNotes($line[14]);
      $plot[$i]->setApproval(1);
      $this->em->persist($plot[$i]);

      $count += 1;
      printf("Oakridge Plots - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();
    

  }

}


// EOF
