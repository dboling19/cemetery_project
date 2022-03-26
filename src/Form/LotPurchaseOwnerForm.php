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
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use App\Entity\Owner;
use Symfony\Component\OptionsResolver\OptionsResolver;



class LotPurchaseOwnerForm extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $this->owners = $options['owners'];

        $builder
            ->add('ownerFullName', ChoiceType::class, [
                'choices' => $options['owners'],    
                'choice_label' => 'ownerFullName',
                'choice_value' => 'ownerFullName',
            ])
            ->add('addOwner', ButtonType::class)
            ->add('submit', submitType::class)
        ;

        // $formModifier = function (FormInterface $form) {
        //     $form
        //         ->add('ownerFullName', TextType::class)
        //     ;
        // };

        // $builder->addEventListener(
        //     FormEvents::PRE_SET_DATA,
        //     function (FormEvent $event) use ($formModifier) {
        //         // this would be your entity, i.e. Owner
        //         $data = $event->getData();

        //         $formModifier($event->getForm());
        //     }
        // );

        // $builder->get('addOwner')->addEventListener(
        //     FormEvents::POST_SUBMIT,
        //     function (FormEvent $event) use ($formModifier) {
        //         // It's important here to fetch $event->getForm()->getData(), as
        //         // $event->getData() will get you the client data (that is, the ID)

        //         // since we've added the listener to the child, we'll have to pass on
        //         // the parent to the callback functions!
        //         $formModifier($event->getForm()->getParent(), $addOwner);
        //     }
        // );


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'owners' => null,
        ));
    }


}

// EOF

?>