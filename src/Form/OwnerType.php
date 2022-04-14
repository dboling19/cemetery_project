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
use App\Entity\Owner;
use Symfony\Component\OptionsResolver\OptionsResolver;


class OwnerType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
      ->add('firstName', TextType::class,[
        'label' => "First Name",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('lastName', TextType::class,[
        'label' => "Last Name",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('address', TextType::class,[
        'label' => "Address",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('city', TextType::class,[
        'label' => "City",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ]
      )
      ->add('state', TextType::class,[
        'label' => "State",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('zipCode', TextType::class,[
        'label' => "Zip Code",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('phoneNum', TextType::class,[
        'label' => "Phone Num",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
      ->add('oldOwner', CheckboxType::class, [
        'required' => false,
        'label' => "Old Owner",
        'label_attr' => [
          'class' => 'labelsClass'
        ],
        'attr'=> [
          'class'=>'inputClass'
        ]
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Owner::class,
    ]);
  }
}

// EOF
