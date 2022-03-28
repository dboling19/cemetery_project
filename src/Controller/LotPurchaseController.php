<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpKernel\Kernel;
use App\Form\LotPurchaseForm;
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

  protected $em;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
  }

  /**
   * Provides the logic and form rendering for the lot purchase form.
   *
   * @author Daniel Boling
   * 
   * @Route("/lot_purchase", name="lot_purchase")
   */
  public function lot_purchase(Request $request, PlotRepository $plot_repo, OwnerRepository $owner_repo, PlotOwnerRepository $po_repo): Response
  {
    // https://symfony.com/doc/current/form/dynamic_form_modification.html#dynamic-generation-for-submitted-forms
    // key to multiple owners

    $sections = $plot_repo->getSectionsArray();
    $spaces = $plot_repo->getSpacesArray();
    $owners = $owner_repo->getOwnerNames();
    // find required data for choice menus in forms

    $form_array = array();
    // passing empty array into form to *hopefully* return an array with data later
    $form = $this->createForm(LotPurchaseForm::class, $form_array, [
      'owners' => $owners,
      'sections' => $sections,
      'spaces' => $spaces,
    ]);
    $form->handleRequest($request);
    // both of these forms will be empty values. This is intended to pull dummy data back from the forms for lookup


    if ($form->isSubmitted() && $form->isValid())
    {
      $form_array = $form->getData();
      var_dump($form_array);
      // form_array returns an array containing elements for owner and plot


      $plot = $plot_repo
        ->findOneBy(
            array('cemetery' => $form_array['cemetery'], 
              'section' => $form_array['section'], 
              'lot' => $form_array['lot'], 
              'space' => $form_array['space']))
          ;
      // find the matching plot based on user input from form

      $owners_array = array();
      foreach ($form_array as $owner_query)
      {
        array_push($owners_array, $owner_repo->findOneBy(array('ownerFullName' => $owner_query)));
        // use findOneBy() to return a single object, allowing easy getters like below
        // instead of findBy(), which returns an array of objects, even if you limit to one.
        // Using findBy() requires indexing for [0] to get the value.
      }
      // find the matching owner(s) based on user input from form

      // var_dump($owners_array);

      $po_reference_query = $po_repo->findOneBy(array(), array('tableId' => 'desc'));
      $po_reference_id = $po_reference_query->getTableId()+1;
      // query for previous plotowner entry for ID and add one

      // foreach ($owners as $owner)
      // {
      //   $po = new PlotOwner();
      //   $po->setPlotId($plot->getPlotId());
      //   $po->setOwnerId($owner->getOwnerId());
      //   // setting up the M-M table input
      //   $this->em->persist($po);
      //   $this->em->flush();
      // }

      // return $this->redirectToRoute('lot_purchase');
      // this may need to redirect elsewhere

    }

    return $this->render('lot_purchase_form.html.twig', [
      'form' => $form->createview(),
      'owners' => $owners,
      'sections' => $sections,
      'spaces' => $spaces,
    ]);

  }


}


// EOF
