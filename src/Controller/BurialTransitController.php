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
use App\Form\BurialTransitForm;
use Doctrine\ORM\EntityRepository;
use App\Repository\PlotRepository;
use App\Repository\OwnerRepository;
use App\Repository\BurialRepository;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;


class BurialTransitController extends AbstractController
{

    protected $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
      $this->em = $entityManager;
      $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
    }

    /**
     * Provides the logic and form rendering for the burial transit form.
     *
     * @author Daniel Boling
     * 
     * @Route("/plot_burial", name="burial_transit")
     */
    public function burial_transit(Request $request, PlotRepository $plot_repo, BurialRepository $burial_repo): Response
    {
        $form_array = array();
        // passing empty array into form to return an array with data later
        $form = $this->createForm(BurialTransitForm::class, $form_array);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid())
        {
          $form_array = $form->getData();
          $burial = $form_array['burial'];
          $plot = $form_array['plot'];

          $plot_query = $plot_repo->findOneBy(array(
            'cemetery' => $plot->getCemetery(),
            'section' => $plot->getSection(),
            'lot' => $plot->getLot(),
            'space' => $plot->getSpace()
          ));
          // find the matching plots based on user input from form and push them to a second array
          $plot_query->setNotes($plot->getNotes());
          $plot = $plot_query;

          $burial_id = $burial_repo->findOneBy(array(), array('id' => 'desc'));
          $burial->setId($burial_id->getId()+1);
          $burial->setApproval(false);
          $this->em->persist($burial);
          // add new burial from array

          $plot->setBurial($burial);
          $plot->setApproval(false);
          // setting up the M-M table input
          $this->em->flush();


          return $this->redirectToRoute('burial_transit');
          // this may need to redirect elsewhere


        }

        return $this->render('burial_transit_form.html.twig', [
          'form' => $form->createview(),
        ]);

    }

}


// EOF
