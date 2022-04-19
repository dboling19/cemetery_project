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
use App\Repository\BurialRepository;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;


class LotPurchaseController extends AbstractController
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
   * @Route("/lot_purchase", name="lot_purchase")
   */
  public function lot_purchase(Request $request, PlotRepository $plot_repo, OwnerRepository $owner_repo): Response
  {

    $form_array = array();
    $plot = new Plot();
    $owner = new Owner();
    array_push($form_array, $plot, $owner);
    // passing empty array into form to *hopefully* return an array with data later
    $form = $this->createForm(LotPurchaseForm::class, $form_array);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid())
    {
      $form_array = $form->getData();
      $owner_array = $form_array['owner'];
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
        if ($plot_query->getNotes() != null or $plot_query->getNotes() != '') {
          // prevents setting notes to null upon form submission. this will only be allowed
          // in the actual plot entity modification page.
          $found_plot->setNotes($plot_query->getNotes());
        }
        // find the matching plots based on user input from form and push them to a second array
      }


      $owners_object_array = array();
      foreach ($owner_array as $owner_query)
      {
        if ($owner_query->getOldOwner() == true)
        {

          $found_owner = $owner_repo->findOneBy(array('firstName' => $owner_query->getFirstName(), 'lastName' => $owner_query->getLastName()));
          // return the one result that matches the sent full name.
          array_push($owners_object_array, $found_owner);
          // use findOneBy() to return a single object, allowing easy getters like below
          // instead of findBy(), which returns an array of objects, even if you limit to one.
          // Using findBy() requires indexing for [0] to get the value.
          $found_owner->setAddress($owner_query->getAddress());
          $found_owner->setCity($owner_query->getCity());
          $found_owner->setState($owner_query->getState());
          $found_owner->setZipcode($owner_query->getZipcode());
          $found_owner->setPhoneNum($owner_query->getPhoneNum());
          $found_owner->setApproval(-1);
          // change old owner info (name will not change)
          // find the matching owner(s) based on user input from form and push them to a second array

        } else {
          $new_id = $owner_repo->findOneBy(array(), array('id' => 'desc'));
          $new_owner = $owner_query;
          $new_owner->setId(($new_id->getId())+1);
          $new_owner->setApproval(-1);
          array_push($owners_object_array, $new_owner);
          $this->em->persist($new_owner);
          // add new owner from array

        }

      }
      $this->em->flush();
      // flush changes made to database

      foreach ($plots_object_array as $plot)
      {
        // for every added plot, set each owner to own the plot.
        foreach ($owners_object_array as $owner)
        {
          $plot->addOwner($owner);
          // $po->setNotarized(0);
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
