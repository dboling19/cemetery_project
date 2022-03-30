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
use App\Form\PlotReleaseForm;
use Doctrine\ORM\EntityRepository;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Repository\PlotOwnerRepository;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\PlotOwner;


class PlotReleaseController extends AbstractController
{

  protected $em;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));

  }

  /**
   * Provides the logic and form rendering for the lot purchase form.
   *
   * @author Daniel Boling
   * 
   * @Route("/plot_release", name="plot_release")
   */
  public function plot_release(Request $request, PlotRepository $plot_repo, OwnerRepository $owner_repo, PlotOwnerRepository $po_repo): Response
  {

    $form_array = array();
    // passing empty array into form to *hopefully* return an array with data later
    $form = $this->createForm(PlotReleaseForm::class, $form_array);
    $form->handleRequest($request);
    // both of these forms will be empty values. This is intended to pull dummy data back from the forms for lookup


    if ($form->isSubmitted() && $form->isValid())
    {
      $form_array = $form->getData();
      $from_owner = $form_array['from_owner'];  
      $to_owner = $form_array['to_owner'];
      $plot_array = $form_array['plot'];
      // form_array returns an array containing elements for owner and plot


      $plots_object_array = array();
      foreach ($plot_array as $plot_query)
      {
        $found_plot = $plot_repo->findOneBy(array(
                'cemetery' => $plot_query->getCemetery(),
                'section' => $plot_query->getSection(),
                'lot' => $plot_query->getLot(),
                'space' => $plot_query->getSpace()
        ));
        array_push($plots_object_array, $found_plot);
        $found_plot->setNotes($plot_query->getNotes());
        // find the matching plots based on user input from form and push them to a second array
      }


      if ($to_owner->getOldOwner() == true) 
      // working with checkbox coming from form to hopefully handle owners better
      {

        $found_to_owner = $owner_repo->findOneBy(array('ownerFullName' => $to_owner->getOwnerFullName()));
        // return the one result that matches the sent full name.
        // use findOneBy() to return a single object, allowing easy getters like below
        // instead of findBy(), which returns an array of objects, even if you limit to one.
        // Using findBy() requires indexing for [0] to get the value.
        $found_to_owner->setStreetAddress($to_owner->getStreetAddress());
        $found_to_owner->setCity($to_owner->getCity());
        $found_to_owner->setState($to_owner->getState());
        $found_to_owner->setZipCode($to_owner->getZipCode());
        $found_to_owner->setPhoneNum($to_owner->getPhoneNum());
        // change old owner info (name will not change)

      } else {
        $this->em->persist($to_owner);
        // add new owner from array

      }
      // find the matching owner based on user input

      $this->em->flush();
      // flush changes made to database

      $from_from_owner = $owner_repo->findOneBy(array('ownerFullName' => $from_owner->getOwnerFullName()));

      foreach ($plots_object_array as $plot)
      {
        // for every added plot, set each owner to own the plot.
        $po = $po_repo->findOneBy(array('ownerId' => $from_from_owner->getOwnerId(), 'plotId' => $plot->getPlotId()));
        $po->setPlotId($plot->getPlotId());
        $po->setOwnerId($found_to_owner->getOwnerId());
        $po->setNotarized(0);
        $po->setDate($this->date);
        // setting up the M-M table input
        $this->em->persist($po);
        $this->em->flush();

      }
      return $this->redirectToRoute('plot_release');
      // this may need to redirect elsewhere

    }

    return $this->render('plot_release_form.html.twig', [
      'form' => $form->createview(),
    ]);

  }


}


// EOF
