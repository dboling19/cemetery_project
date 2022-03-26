<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PlotRepository;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\PlotOwner;

class DisplayController extends AbstractController
{
    /**
   * This should be the main page that everyone should see. Every user should be able to see this page and everything
   * on it. This will be modified more clearly from it's current state. Currently
   * being used as a testing stage for database outputs.
   * 
   * @author Daniel Boling
   * @return rendered display.html.twig
   * 
   * @Route("/", name="display")
   */
  public function display(PlotRepository $plot_repository): Response
  {

    $plot = $plot_repository->findBy(array(), array('plotId' => 'desc'), 10);


    return $this->render('display.html.twig', [
        'plot' => $plot,
    ]);

  }
}


// EOF
