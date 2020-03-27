<?php

namespace App\Form;

use App\Entity\Infosup;
use App\Form\DataTransforme\FrenchToDataTransforme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InfovoitureType extends AbstractType
{
    private $transformer;

    public function __construct(FrenchToDataTransforme $transformer)
    {
        $this->transformer = $transformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVidDep', TextType::class,[
                'label' => 'Date départ de vidange',
            ])
            ->add('dateVidFin', TextType::class,[
                'label' => 'Date Fin de vidange',
            ])
            ->add('dateChanRouDep', TextType::class,[
                'label' => 'Date départ de changemant roue',
            ])
            ->add('dateChanRouFin', TextType::class,[
                'label' => 'Date Fin de changemant roue',
            ])
            ->add('dateVisTechDep', TextType::class,[
                'label' => 'Date départ de visite Technique',
            ])
            ->add('dateVisTechFin', TextType::class,[
                'label' => 'Date Fin de visite Technique',
            ])
            ->add('dateAssurDep', TextType::class,[
                'label' => 'Date départ d\'assurance',
            ])
            ->add('dateAssurFin', TextType::class,[
                'label' => 'Date Fin d\'assurrance',
            ])
        ;
        $builder->get('dateVidDep')->addModelTransformer($this->transformer);
        $builder->get('dateVidFin')->addModelTransformer($this->transformer);
        $builder->get('dateChanRouDep')->addModelTransformer($this->transformer);
        $builder->get('dateChanRouFin')->addModelTransformer($this->transformer);
        $builder->get('dateVisTechDep')->addModelTransformer($this->transformer);
        $builder->get('dateVisTechFin')->addModelTransformer($this->transformer);
        $builder->get('dateAssurDep')->addModelTransformer($this->transformer);
        $builder->get('dateAssurFin')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Infosup::class,
        ]);
    }
}
