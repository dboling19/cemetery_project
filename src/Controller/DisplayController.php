<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Repository\PlotRepository;
use App\Form\OwnerForm;
use App\Form\BurialForm;
use App\Form\PlotForm;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;


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
   * @Route("/", name="plot_display")
   */
  public function display(PlotRepository $plot_repo): Response
  {

    $plot = $plot_repo->findBy(array(), array('plotId' => 'desc'), 10);


    return $this->render('plot_display.html.twig', [
        'plot' => $plot,
    ]);

  }
}


// EOF
