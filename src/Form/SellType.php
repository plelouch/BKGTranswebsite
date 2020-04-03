<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Sell;
use App\Entity\Voiture;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price', MoneyType::class, [
                'label' => 'Prix de vente',
                'attr' => [
                    'placeholder' => "Saisir le prix de vente de la voiture"
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'fullName'
            ])
            ->add('car', EntityType::class, [
                'class' => Voiture::class,
                'label' => "Voiture",
                'query_builder' => function (EntityRepository $repository){
                    return $repository->createQueryBuilder('v')
                        ->join('v.type', 't')
                        ->where('v.isDispo = :val')
                        ->andWhere('t.name = :val1')
                        ->setParameters(['val' => true, 'val1' => "vente"]);
                },
                'choice_label' => 'marque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sell::class,
        ]);
    }
}
