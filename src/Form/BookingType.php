<?php

namespace App\Form;

use App\Entity\Booking;
use App\Form\DataTransforme\FrenchToDataTransforme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    private $tramsformer;

    public function __construct(FrenchToDataTransforme $tramsformer)
    {
        $this->tramsformer = $tramsformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startDate', TextType::class, [
                'label' => "Date d'arrivée",
                'attr' => [
                    'placeholder' => "Saisire la date d'arrivée "
                ]
            ])
            ->add('endDate', TextType::class, [
                'label' => "Date de départ",
                'attr' => [
                    'placeholder' => "Saisir la date de départ"
                ]
            ])
            ->add('comment', TextareaType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => "SI vous avez un commentaire n'hésitez pas à faire par !"
                ]
            ])
        ;
        $builder->get('startDate')->addModelTransformer($this->tramsformer);
        $builder->get('endDate')->addModelTransformer($this->tramsformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
