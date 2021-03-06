<?php

namespace App\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PlotReleaseForm extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
      ->add('from_owner', OwnerType::class)
      ->add('to_owner', CollectionType::class, [
        'entry_type' => OwnerType::class,
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'delete_empty' => true,
      ])
      ->add('plot', CollectionType::class, [
        'entry_type' => PlotType::class,
        'allow_add' => true,
        'allow_delete' => true,
        'prototype' => true,
        'delete_empty' => true,
      ])
      // ->add('notarized', CheckboxType::class, [
      //   'required' => false,
      // ])
      ->add('date', DateType::class)
      ->add('submit', SubmitType::class, [
        'label' => 'Submit Record',
      ])
    ;

  }

}


// EOF
