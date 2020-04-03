<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Property;
use App\Entity\Sell;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SellPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('price')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'fullName'
            ])
            ->add('property', EntityType::class, [
                'class' => Property::class,
                'choice_label' => 'title'
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
