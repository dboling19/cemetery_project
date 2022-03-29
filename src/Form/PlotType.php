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
use App\Entity\Plot;
use Symfony\Component\OptionsResolver\OptionsResolver;



class PlotType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
      ->add('cemetery', ChoiceType::class, [
        'choices' => [
          'West Goshen' => 'West Goshen',
          'Oakridge' => 'Oakridge',
          'Violet' => 'Violet'
        ],
      ])
      ->add('section', TextType::class)
      ->add('lot', TextType::class)
      ->add('space', TextType::class)
      ->add('notes', TextAreaType::class)
    ;


  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Plot::class,
    ]);
  }


}


// EOF
