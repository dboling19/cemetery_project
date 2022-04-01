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
use App\Entity\Burial;
use Symfony\Component\OptionsResolver\OptionsResolver;


class BurialType extends AbstractType
{

  public function __construct()
  {
    $this->date = new \DateTime('now', new \DateTimeZone('America/Indiana/Indianapolis'));
  }

  public function buildForm(FormBuilderInterface $builder, array $options): void
  {

    $builder
      ->add('burialFirst', TextType::class)
      ->add('burialLast', TextType::class)
      ->add('date', DateType::class, [
          'data' => $this->date,
      ])
      ->add('cremation', CheckboxType::class, [
        'required' => false,
      ])
      ->add('funeralHome', TextType::class, [
          'required' => false,
      ])
    ;
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      'data_class' => Burial::class,
    ]);
  }
}

// EOF
