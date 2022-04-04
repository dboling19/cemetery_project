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
use App\Form\OwnerForm;
use App\Form\BurialForm;
use App\Form\PlotForm;
use App\Entity\Plot;
use App\Entity\Owner;
use App\Entity\Burial;
use App\Entity\PlotOwner;


class EntityController extends AbstractController
{

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->em = $entityManager;
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }

  /**
   * Displays the list of owners in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered owner_display.html.twig
   * 
   * @Route("/owners/{column}/{order}/{result}", name="owner_display")
   */
  public function owner_display(Request $request, OwnerRepository $owner_repo, $order = 'asc', $column = 'ownerId', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }

    // $form_array = array();
    // $search_form = $this->createForm(SearchForm::class, $form_array);
    // $search_form->handleRequest($request);
    // if ($search_form->isSubmitted() && $search_form->isValid())
    // {
    //   return $this->redirectToRoute('search_burial');

    // }

    $result = $owner_repo->findBy(array(), array($column => $order));


    return $this->render('displays/owner_display.html.twig', [
        'result' => $result,
        'order' => $order,
    ]);

  }


  /**
   * Loads the owner chosen from owner_display and handles modification.
   * 
   * @author Daniel Boling
   * @return rendered owner_form.html.twig
   * 
   * @Route("/modify/owner/{owner_id}", name="modify_owner")
   */
  public function modify_owner(Request $request, OwnerRepository $owner_repo, $owner_id): Response
  {
    $owner = $owner_repo->findOneBy(array('ownerId' => $owner_id));
    $owner_form = $this->createForm(OwnerForm::class, $owner);
    $owner_form->handleRequest($request);

    if($owner_form->isSubmitted() && $owner_form->isValid())
    {
      $owner = $owner_form->getData();
      $owner->setApproval(0);
      $this->em->persist($owner);
      $this->em->flush();

      // return $this->redirectToRoute('owner_display');
    }

    return $this->render('modify_forms/modify_owner.html.twig', [
      'owner_form' => $owner_form->createView(),
    ]);

  }


  /**
   * Toggles the approval status of owner entries.
   * 
   * @author Daniel Boling
   * 
   * @Route("/approval/owner/{owner_id}", name="toggle_owner_approval")
   */
  public function toggle_owner_approval(Request $request, OwnerRepository $owner_repo, $owner_id): Response
  {
    $owner = $owner_repo->findOneBy(array('ownerId' => $owner_id)); 


    if($owner->getApproval() == 1)
    // if currently approved
    {
      $owner->setApproval(0);
    } else {
      $owner->setApproval(1);
    }
    $this->em->persist($owner);
    $this->em->flush();

    return $this->redirectToRoute('owner_display');

  }


  /**
   * Displays the list of burials in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered burial_display.html.twig
   * 
   * @Route("/burials/{column}/{order}/{result}", name="burial_display")
   */
  public function burial_display(Request $request, BurialRepository $burial_repo, $order = 'asc', $column = 'burialId', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }

    // $form_array = array();
    // $search_form = $this->createForm(SearchForm::class, $form_array);
    // $search_form->handleRequest($request);
    // if ($search_form->isSubmitted() && $search_form->isValid())
    // {
    //   return $this->redirectToRoute('search_burial');

    // }

    $result = $burial_repo->findBy(array(), array($column => $order));


    // foreach ($burial as $selection)
    // {
    //   if ($selection->getDate() == null)
    //   // check if the datetime object is null - this is due to the miscellaneous date formatting and inputs in the original data
    //   {
    //     if ($selection->getBurialDay() != null && $selection->getBurialMonth() != null && $selection->getBurialYear() != null)
    //     {
    //       // this will only fire if all three date inputs are null. Otherwise no date will be shown.
    //       $new_date = new \DateTime($selection->getBurialMonth() . '/' . $selection->getBurialDay() . '/' . $selection->getBurialYear());
    //       $selection->setDate($new_date);
    //       $this->em->persist($selection);
    //     }

    //   }
    // }
    // $this->em->flush();
    // uncomment and modify later as data is added.


    return $this->render('displays/burial_display.html.twig', [
        'result' => $result,
        'order' => $order,
        // 'search_form' => $search_form,
    ]);

  }


  /**
   * Loads the burial chosen from burial_display and handles modification.
   * 
   * @author Daniel Boling
   * @return rendered burial_form.html.twig
   * 
   * @Route("/modify/burial/{burial_id}", name="modify_burial")
   */
  public function modify_burial(Request $request, BurialRepository $burial_repo, $burial_id): Response
  {
    $burial = $burial_repo->findOneBy(array('burialId' => $burial_id));
    var_dump($burial);
    $burial_form = $this->createForm(BurialForm::class, $burial);
    $burial_form->handleRequest($request);

    if($burial_form->isSubmitted() && $burial_form->isValid())
    {
      $burial = $burial_form->getData();
      $burial->setApproval(0);
      $this->em->persist($burial);
      $this->em->flush();

      return $this->redirectToRoute('burial_display');
    }

    return $this->render('modify_forms/modify_burial.html.twig', [
      'burial_form' => $burial_form->createView(),
    ]);

  }


  /**
   * Toggles the approval status of burial entries.
   * 
   * @author Daniel Boling
   * 
   * @Route("/approval/burial/{burial_id}", name="toggle_burial_approval")
   */
  public function toggle_burial_approval(Request $request, BurialRepository $burial_repo, $burial_id): Response
  {
    $burial = $burial_repo->findOneBy(array('burialId' => $burial_id)); 


    if($burial->getApproval() == 1)
    // if currently approved
    {
      $burial->setApproval(0);
    } else {
      $burial->setApproval(1);
    }
    $this->em->persist($burial);
    $this->em->flush();

    return $this->redirectToRoute('burial_display');

  }


  /**
   * Displays the list of plots in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered plot_display.html.twig
   * 
   * @Route("/plots/{column}/{order}/{result}", name="plot_display")
   */
  public function plot_display(Request $request, PlotRepository $plot_repo, $order = 'asc', $column = 'plotId', $result = NULL): Response
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
      // $result = $plot_repo->createQueryBuilder('p')
      //   ->join('p.section', 's')
      //   ->join('p.lot', 'l')
      //   ->join('p.space', 's')
      //   ->orderBy('p', $order)
      //   ->getQuery()
      //   ->getResult()
      // ;

      $result = $plot_repo->findBy(array(), array('section' => $order, 'lot' => $order, 'space' => $order));


    } else {
      $result = $plot_repo->findBy(array(), array($column => $order));
    }



    return $this->render('displays/plot_display.html.twig', [
        'result' => $result,
        'order' => $order,
        // 'search_form' => $search_form,
    ]);

  }


  /**
   * Loads the plot chosen from plot_display and handles modification.
   * 
   * @author Daniel Boling
   * @return rendered plot_form.html.twig
   * 
   * @Route("/modify/plot/{plot_id}", name="modify_plot")
   */
  public function modify_plot(Request $request, PlotRepository $plot_repo, $plot_id): Response
  {
    $plot = $plot_repo->findOneBy(array('plotId' => $plot_id));
    $plot_form = $this->createForm(PlotForm::class, $plot);
    $plot_form->handleRequest($request);

    if($plot_form->isSubmitted() && $plot_form->isValid())
    {
      $plot = $plot_form->getData();
      $plot->setApproval(0);
      $this->em->persist($plot);
      $this->em->flush();

      return $this->redirectToRoute('plot_display');
    }

    return $this->render('modify_forms/modify_plot.html.twig', [
      'plot_form' => $plot_form->createView(),
    ]);

  }


  /**
   * Toggles the approval status of plot entries.
   * 
   * @author Daniel Boling
   * 
   * @Route("/approval/plot/{plot_id}", name="toggle_plot_approval")
   */
  public function toggle_plot_approval(Request $request, PlotRepository $plot_repo, $plot_id): Response
  {
    $plot = $plot_repo->findOneBy(array('plotId' => $plot_id)); 


    if($plot->getApproval() == 1)
    // if currently approved
    {
      $plot->setApproval(0);
    } else {
      $plot->setApproval(1);
    }
    $this->em->persist($plot);
    $this->em->flush();

    return $this->redirectToRoute('plot_display');

  }


}


// EOF
