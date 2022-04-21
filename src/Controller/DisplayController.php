<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
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
use App\Form\SearchForm;
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
  public function display(Request $request, PlotRepository $plot_repo, PaginatorInterface $paginator): Response
  {
    $search = $request->query->get('search');
    $search_array = explode(', ', $search);
    // foreach($search_array as $term) {
    //   $search_array[array_search($term, $search_array)] = '%'.$term.'%';
    // }

    if($search != null)
    {
      $searched = true;
      $queryBuilder = $plot_repo->findAllRelated(null, $search);
    } else {
      $searched = false;
      $queryBuilder = $plot_repo->findAllRelated();
    }


    $pagination = $paginator->paginate(
      $queryBuilder, /* query NOT result */
      $request->query->getInt('page', 1) /* pull page number from url or default to 1 */,
      20 /*limit per page*/
    );

    return $this->render('displays/display_all.html.twig', [
      'result' => $pagination,
      'searched' => $searched,
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
  public function details(Request $request, PlotRepository $plot_repo, PaginatorInterface $paginator, $id): Response
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
   * @Route("/owners", name="owner_display")
   */
  public function owner_display(Request $request, OwnerRepository $owner_repo, PaginatorInterface $paginator): Response
  {
    $search = $request->query->get('search');

    if($search != null)
    {
      $searched = true;
      $queryBuilder = $owner_repo->findAllRelated($search);
    } else {
      $searched = false;
      $queryBuilder = $owner_repo->findAllRelated();
    }


    $pagination = $paginator->paginate(
      $queryBuilder, /* query NOT result */
      $request->query->getInt('page', 1) /* pull page number from url or default to 1 */,
      20 /*limit per page*/
    );

    return $this->render('displays/owner_display.html.twig', [
      'result' => $pagination,
      'searched' => $searched,
    ]);

  }


  /**
   * Displays the list of burials in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered burial_display.html.twig
   * 
   * @Route("/burials", name="burial_display")
   */
  public function burial_display(Request $request, BurialRepository $burial_repo, PaginatorInterface $paginator): Response
  { 
    $search = $request->query->get('search');

    if($search != null)
    {
      $searched = true;
      $queryBuilder = $burial_repo->findAllRelated($search);
    } else {
      $searched = false;
      $queryBuilder = $burial_repo->findAllRelated();
    }


    $pagination = $paginator->paginate(
      $queryBuilder, /* query NOT result */
      $request->query->getInt('page', 1) /* pull page number from url or default to 1 */,
      20 /*limit per page*/
    );

    return $this->render('displays/burial_display.html.twig', [
      'result' => $pagination,
      'searched' => $searched,
    ]);

  }


  /**
   * Displays the list of plots in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered plot_display.html.twig
   * 
   * @Route("/plots", name="plot_display")
   */
  public function plot_display(Request $request, PlotRepository $plot_repo, PaginatorInterface $paginator): Response
  {
    $search = $request->query->get('search');

    if($search != null)
    {
      $searched = true;
      $queryBuilder = $plot_repo->findAllRelated(null, $search);
    } else {
      $searched = false;
      $queryBuilder = $plot_repo->findAllRelated();
    }


    $pagination = $paginator->paginate(
      $queryBuilder, /* query NOT result */
      $request->query->getInt('page', 1) /* pull page number from url or default to 1 */,
      20 /*limit per page*/
    );

    return $this->render('displays/plot_display.html.twig', [
      'result' => $pagination,
      'searched' => $searched,
    ]);

  }

}


// EOF
