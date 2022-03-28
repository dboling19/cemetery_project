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
use App\Entity\Owner;
use Symfony\Component\OptionsResolver\OptionsResolver;



class LotPurchaseForm extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $this->owners = $options['owners'];
    $this->sections = $options['sections'];
    $this->spaces = $options['spaces'];

    $builder
      ->add('owner', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('street_address', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('city', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('state', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('zip_code', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('phone_num', CollectionType::class, [
        'entry_type' => TextType::class,
        'allow_add' => true,
        'allow_delete' => true,
      ])
      ->add('cemetery', ChoiceType::class, [
        'choices' => [
          'West Goshen' => 'West Goshen',
          'Oakridge' => 'Oakridge',
          'Violet' => 'Violet'
        ],
      ])
      ->add('section', ChoiceType::class, [
        'choices' => $this->sections,
      ])
      ->add('lot', TextType::class)
      ->add('space', ChoiceType::class, [
        'choices' => $this->spaces,
      ])
      ->add('notes', TextAreaType::class, [
        'required' => false,
      ])
      ->add('submit', SubmitType::class, [
        'label' => 'Submit Record'
      ])
    ;


  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(
      'owners' => null,
      'sections' => null,
      'spaces' => null,
    ));
  }


}

// EOF

?>