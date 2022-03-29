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

    $form_array = array();
    // passing empty array into form to *hopefully* return an array with data later
    $form = $this->createForm(LotPurchaseForm::class, $form_array);
    $form->handleRequest($request);
    // both of these forms will be empty values. This is intended to pull dummy data back from the forms for lookup


    if ($form->isSubmitted() && $form->isValid())
    {
      $form_array = $form->getData();
      $owner_array = $form_array['owner'];
      $plot_array = $form_array['plot'];
      // form_array returns an array containing elements for owner and plot


      $plots_object_array = array();
      foreach ($plot_array as $plot_query)
      {
        array_push($plots_object_array, $plot_repo
          ->findOneBy(
              array('cemetery' => $plot_query->getCemetery(),
                'section' => $plot_query->getSection(),
                'lot' => $plot_query->getLot(),
                'space' => $plot_query->getSpace()))
          );
        // find the matching plots based on user input from form and push them to a second array
      }


      $owners_object_array = array();
      foreach ($owner_array as $owner_query)
      {
        if ($owner_query->getOldOwner() == true)
        {

          $found_owner = $owner_repo->findOneBy(array('ownerFullName' => $owner_query->getOwnerFullName()));
          // return the one result that matches the sent full name. 
          array_push($owners_object_array, $found_owner);
          // use findOneBy() to return a single object, allowing easy getters like below
          // instead of findBy(), which returns an array of objects, even if you limit to one.
          // Using findBy() requires indexing for [0] to get the value.
          $found_owner->setStreetAddress($owner_query->getStreetAddress());
          $found_owner->setCity($owner_query->getCity());
          $found_owner->setState($owner_query->getState());
          $found_owner->setZipCode($owner_query->getZipCode());
          $found_owner->setPhoneNum($owner_query->getPhoneNum());
          // change old owner info (name will not change)

        } else {
          $new_owner = $owner_query;
          $this->em->persist($new_owner);
          // add new owner from array

        }

      }
      // find the matching owner(s) based on user input from form and push them to a second array

      $this->em->flush();
      // flush changes made to database

      foreach ($plots_object_array as $plot)
      {
        // for every added plot, set each owner to own the plot.
        foreach ($owners_object_array as $owner)
        {
          $po = new PlotOwner();
          $po->setPlotId($plot->getPlotId());
          $po->setOwnerId($owner->getOwnerId());
          // setting up the M-M table input
          $this->em->persist($po);
          $this->em->flush();
        }

      }
      return $this->redirectToRoute('lot_purchase');
      // this may need to redirect elsewhere

    }

    return $this->render('lot_purchase_form.html.twig', [
      'form' => $form->createview(),
    ]);

  }


}


// EOF
