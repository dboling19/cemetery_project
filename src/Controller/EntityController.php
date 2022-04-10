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
  public function owner_display(Request $request, OwnerRepository $owner_repo, $order = 'asc', $column = 'id', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }


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
   * @Route("/modify/owner/{id}", name="modify_owner")
   */
  public function modify_owner(Request $request, OwnerRepository $owner_repo, $id): Response
  {
    $owner = $owner_repo->findOneBy(array('ownerId' => $id));
    $owner_form = $this->createForm(OwnerForm::class, $owner);
    $owner_form->handleRequest($request);

    if($owner_form->isSubmitted() && $owner_form->isValid())
    {
      $owner = $owner_form->getData();
      $owner->setApproval(0);
      $this->em->persist($owner);
      $this->em->flush();

      return $this->redirectToRoute('owner_display', [
        $order = 'asc', $column = 'id'
      ]);
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
   * @Route("/approval/owner/{id}", name="toggle_owner_approval")
   */
  public function toggle_owner_approval(Request $request, OwnerRepository $owner_repo, $id): Response
  {
    $owner = $owner_repo->findOneBy(array('id' => $id)); 


    if($owner->getApproval() == 1)
    // if currently approved
    {
      $owner->setApproval(0);
    } else {
      $owner->setApproval(1);
    }
    $this->em->persist($owner);
    $this->em->flush();

    return $this->redirectToRoute('owner_display', [
      $order = 'asc', $column = 'id'
    ]);

  }


  /**
   * Displays the list of burials in the system and shows their information.
   * 
   * @author Daniel Boling
   * @return rendered burial_display.html.twig
   * 
   * @Route("/burials/{column}/{order}/{result}", name="burial_display")
   */
  public function burial_display(Request $request, BurialRepository $burial_repo, $order = 'asc', $column = 'id', $result = NULL): Response
  {

    if ($order == 'asc')
    // if page was previously asc, load next with desc.
    {
      $order = 'desc';
    } else {
      $order = 'asc';
    }

    $result = $burial_repo->findBy(array(), array($column => $order));

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
   * @Route("/modify/burial/{id}", name="modify_burial")
   */
  public function modify_burial(Request $request, BurialRepository $burial_repo, $id): Response
  {
    $burial = $burial_repo->findOneBy(array('id' => $id));
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
   * @Route("/approval/burial/{id}", name="toggle_burial_approval")
   */
  public function toggle_burial_approval(Request $request, BurialRepository $burial_repo, $id): Response
  {
    $burial = $burial_repo->findOneBy(array('id' => $id));


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
   * @Route("/{column}/{order}/{result}", name="plot_display")
   */
  public function plot_display(Request $request, PlotRepository $plot_repo, $order = 'desc', $column = 'id', $result = NULL): Response
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
   * @Route("/modify/plot/{id}", name="modify_plot")
   */
  public function modify_plot(Request $request, PlotRepository $plot_repo, $id): Response
  {
    $plot = $plot_repo->findOneBy(array('id' => $id));
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
   * @Route("/approval/plot/{id}", name="toggle_plot_approval")
   */
  public function toggle_plot_approval(Request $request, PlotRepository $plot_repo, $id): Response
  {
    $plot = $plot_repo->findOneBy(array('id' => $id)); 


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
