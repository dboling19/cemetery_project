<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Kernel;
use App\Form\LotPurchasePlotForm;
use App\Form\LotPurchaseOwnerForm;
use Doctrine\ORM\EntityRepository;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\PlotOwnerRepository;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\PlotOwner;


class LotPurchaseController extends AbstractController
{

private function __controller()
{
  $this->em = $this->getDoctrine()->getManager();
}

  /**
   * Provides the logic and form rendering for the lot purchase form.
   *
   * @author Daniel Boling
   * 
   * @Route("/lot_purchase", name="lot_purchase")
   */
  public function lot_purchase(Request $request, PlotRepository $plot_repo, OwnerRepository $owner_repo): Response
  {
    // https://symfony.com/doc/current/form/dynamic_form_modification.html#dynamic-generation-for-submitted-forms
    // key to multiple owners

    $sections = $plot_repo->getSectionsArray();
    $spaces = $plot_repo->getSpacesArray();
    $owners = $owner_repo->findAll();
    // find required data for choice menus in forms

    $plot = new Plot();
    $plot_form = $this->createForm(LotPurchasePlotForm::class, $plot, [
      'sections' => $sections,
      'spaces' => $spaces,
    ]);
    $plot_form->handleRequest($request);

    $owner = new Owner();
    $owner_form = $this->createForm(LotPurchaseOwnerForm::class, $owner, [
      'owners' => $owners,
    ]);
    $owner_form->handleRequest($request);
    // both of these forms will be empty values. This is intended to pull dummy data back from the forms for lookup

    $plot_owner = new PlotOwner();

    if ($owner_form->isSubmitted() && $owner_form->isValid())
    {
      $plot = $plot_form->getData();
      $owner = $owner_form->getData();

      $plot = $plot_repo
      ->findBy(
        array(
            'section' => $plot->getSection()
          , 'lot' => $plot->getLot()
          , 'space' => $plot->getSpace()
          , 'cemetery' => $plot->getCemetery()
        )
      );
      // find the matching plot based on user input from form
      var_dump($plot);
      echo "<br>";

      $plot_owner->setPlotId($plot->getPlotId());
      $plot_owner->setOwnerId($owner->getOwnerId());
      // setting up the M-M table input
      var_dump($plot_owner);
      $em->flush();

      return $this->redirectToRoute('lot_purchase');
      // this may need to redirect elsewhere

    }

    return $this->render('lot_purchase_form.html.twig', [
      'plot_form' => $plot_form->createview(),
      'owner_form' => $owner_form->createview(),
    ]);

  }
}


// EOF
