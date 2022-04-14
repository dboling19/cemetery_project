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

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }


  /**
   * Displays all useful information to the user
   * 
   * @author Daniel Boling
   * @return rendered display.html.twig
   * 
   * @Route("/", name="display")
   */
  public function display(Request $request, PlotRepository $plot_repo): Response
  {

    $result = $plot_repo->findAllRelated();

    return $this->render('displays/display_all.html.twig', [
      'result' => $result,
    ]);

  }


  /**
   * Displays all useful information to the user about the specified plot
   * 
   * @author Daniel Boling
   * @return rendered details.html.twig
   * 
   * @Route("/details/{id}", name="details")
   */
  public function details(Request $request, PlotRepository $plot_repo, $id): Response
  {

    $result = $plot_repo->findAllRelated($id);

    return $this->render('displays/details.html.twig', [
      'result' => $result,
    ]);

  }


  /**
   * Displays the list of owners in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered owner_display.html.twig
   * 
   * @Route("/owners/{column}/{order}/{result}", name="owner_display")
   */
  public function owner_display(Request $request, OwnerRepository $owner_repo, $order = 'asc', $column = 'id', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }


    $result = $owner_repo->findBy(array(), array($column => $order));


    return $this->render('displays/owner_display.html.twig', [
        'result' => $result,
        'order' => $order,
    ]);

  }


  /**
   * Displays the list of burials in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered burial_display.html.twig
   * 
   * @Route("/burials/{column}/{order}/{result}", name="burial_display")
   */
  public function burial_display(Request $request, BurialRepository $burial_repo, $order = 'asc', $column = 'id', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }

    $result = $burial_repo->findBy(array(), array($column => $order));

    return $this->render('displays/burial_display.html.twig', [
        'result' => $result,
        'order' => $order,
    ]);

  }


  /**
   * Displays the list of plots in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered plot_display.html.twig
   * 
   * @Route("/plots/{column}/{order}/{result}", name="plot_display")
   */
  public function plot_display(Request $request, PlotRepository $plot_repo, $order = 'desc', $column = 'id', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }

    if ($column == 'plot')
    {
      $result = $plot_repo->findBy(array(), array('section' => $order, 'lot' => $order, 'space' => $order));
    } else {
      $result = $plot_repo->findBy(array(), array($column => $order));
    }



    return $this->render('displays/plot_display.html.twig', [
        'result' => $result,
        'order' => $order,
    ]);

  }

}


// EOF
