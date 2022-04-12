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
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;


class PlotReleaseController extends AbstractController
{

  protected $em;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));

  }

  /**
   * Provides the logic and form rendering for the lot purchase and affidavit forms.
   *
   * @author Daniel Boling
   * 
   * @Route("/owner_transfer", name="owner_transfer")
   */
  public function owner_transfer(Request $request, PlotRepository $plot_repo, OwnerRepository $owner_repo): Response
  {

    $form_array = array();
    // passing empty array into form to *hopefully* return an array with data later
    $form = $this->createForm(PlotReleaseForm::class, $form_array);
    $form->handleRequest($request);


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

        $found_to_owner = $owner_repo->findOneBy(array('firstName' => $to_owner->getFirstName(), 'lastName' => $to_owner->getLastName()));
        // return the one result that matches the sent full name.
        // use findOneBy() to return a single object, allowing easy getters like below
        // instead of findBy(), which returns an array of objects, even if you limit to one.
        // Using findBy() requires indexing for [0] to get the value.
        $found_to_owner->setAddress($to_owner->getAddress());
        $found_to_owner->setCity($to_owner->getCity());
        $found_to_owner->setState($to_owner->getState());
        $found_to_owner->setZipcode($to_owner->getZipcode());
        $found_to_owner->setPhoneNum($to_owner->getPhoneNum());
        // change old owner info (name will not change)

      } else {
        $this->em->persist($to_owner);
        // add new owner from array

      }
      // find the matching owner based on user input

      $this->em->flush();
      // flush changes made to database

      $from_from_owner = $owner_repo->findOneBy(array('firstName' => $from_owner->getFirstName(), 'lastName' => $from_owner->getLastName()));

      foreach ($plots_object_array as $plot)
      {
        // for every added plot, set each owner to own the plot.
        $plot = $plot_repo->findOneBy(array('id' => $plot->getId()));
        $plot->removeOwner($from_from_owner);
        $plot->addOwner($found_to_owner);
        // $plot->setNotarized($form_array['notarized']);
        // setting up the M-M table input
        $this->em->flush();

      }
      return $this->redirectToRoute('owner_transfer');
      // this may need to redirect elsewhere

    }

    return $this->render('plot_release_form.html.twig', [
      'form' => $form->createview(),
    ]);

  }


}


// EOF
