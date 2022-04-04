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
use App\Form\SearchForm;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\PlotOwner;


class SearchController extends AbstractController
{
  /**
   * Handles the search functionality of each respective page.
   * 
   * @author Daniel Boling
   * 
   * @Route("/search/burial/", name="search_burial")
   */
  public function burial_search(Request $request, BurialRepository $burial_repo): Response
  {

    $form_array = array();
    $search_form = $this->createForm(SearchForm::class, $form_array);
    $search_form->handleRequest($request);

    if ($search_form->isSubmitted() && $search_form->isValid())
    {
      $query->getData();
    
      $fields = array('firstName', 'lastName', 'funeralHome', 'date');
      $result = array();
      foreach ($fields as $field)
      {
        array_merge($result, $burial = $burial_repo->findBy(array($field => $query)));
      }

    }


    // return $this->redirectToRoute('burial_display', [
    //   'result' => $result,
    // ]);

  }
}


// EOF
