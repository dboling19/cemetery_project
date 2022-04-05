<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class LotPurchaseForm extends AbstractType
{

  public function __construct()
  {
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
      ->add('owner', CollectionType::class, [
        'entry_type' => OwnerType::class,
        'entry_options' => [
          'label' => false,
        ],
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'delete_empty' => true,
      ])
      ->add('plot', CollectionType::class, [
        'entry_type' => PlotType::class,
        'entry_options' => [
          'label' => false,
        ],
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'delete_empty' => true,
      ])
      ->add('date', DateType::class, [
        'data' => $this->date,
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Submit Record',
      ])
    ;

  }

}


// EOF
