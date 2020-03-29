<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Location;
use App\Entity\Property;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateLocation', DateType::class,[
                'label' => 'Date de location '
            ])
            ->add('ArriveAt', DateTimeType::class,[
                'label' => 'Date d\'arrivée',
            ])
            ->add('price', MoneyType::class,[
                'label' => 'Prix de la location',
                'attr' => [
                    'placeholder' => 'Saisir le prix de la location'
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'nom'
            ])
            ->add('property', EntityType::class, [
                'class' => Property::class,'query_builder' => function (EntityRepository $repository){
                    return $repository->createQueryBuilder('p')
                        ->join('p.type', 't')
                        ->where('p.sold = :val')
                        ->andWhere('t.name = :val1')
                        ->setParameters(['val' => true, 'val1' => "Location"]);
                },
                'choice_label' => 'title'
            ])
            ->add('avance', IntegerType::class, [
                'label' => "Avance ",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
