<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures
{
  public function load(ObjectManager $manager): void
  {

    $csv = fopen(dirname(__FILE__).'C:\Users\Daniel Boling\Documents\Cemetery Project\CSV\West Goshen Burial.csv', 'r');
    $i = 0;
    


    $manager->flush();
  }
}


// EOF
