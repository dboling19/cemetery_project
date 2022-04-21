<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\PlotFixtures;
use App\DataFixtures\BurialFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\Plot;


class PlotBurialFixtures extends Fixture implements DependentFixtureInterface
{

  public function __construct(EntityManagerInterface $entityManager, PlotRepository $plot_repo, BurialRepository $burial_repo)
  {
    $this->em = $entityManager;
    $this->plot_repo = $plot_repo;
    $this->burial_repo = $burial_repo;
    // $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }


  /**
   * Takes the csv file and standardizes the input information for submission.
   * 
   * @author Daniel Boling
   */
  public function load(ObjectManager $manager): void
  {
    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Plot-Burial M-M.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    while (($line = fgetcsv($csv)) !== false)
    {
      $plot = $this->plot_repo->find((int)$line[1]);
      $burial = $this->burial_repo->find((int)$line[2]);
      $plot->setBurial($burial);

      $count += 1;
      printf("WG PB - %.2f%%\n", ($count/$file_count)*100);

    }
    $this->em->flush();


    $filename = 'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\Violet Cemetery.csv';
    $csv = fopen($filename, 'r');
    $file_count = count(file($filename));
    $count = 0;
    $i = 0;
    
    while (($line = fgetcsv($csv)) !== false) 
    {
      if ($line[7] != null or $line[7] != '' and $line[8] != null or $line[8] != '')
      {
        $plot = $this->plot_repo->findOneBy(array('cemetery' => 'Violet', 'section' => $line[3], 'lot' => $line[4], 'space' => $line[5]));
        $burial = $this->burial_repo->findOneBy(array('firstName' => $line[7], 'lastName' => $line[8]));
        $plot->setBurial($burial);

      }
      $count += 1;
      printf("Violet PB - %.2f%%\n", ($count/$file_count)*100);
    }
    $this->em->flush();


  }

  
  public function getDependencies()
  {
    return [
      PlotFixtures::class,
      BurialFixtures::class,
    ];
  }
}


// EOF
