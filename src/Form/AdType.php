<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de l\'annonce',
                'attr' => [
                    'placehoder' => 'Entrez un Titre'
                ]
            ])
            ->add('introduction', TextType::class, [
                'label' => 'Introduction',
                'attr' => [
                    'placehoder' => 'Entrez une petite introduction'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => [
                    'placehoder' => 'Entrez une description'
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Le prix de location',
                'attr' => [
                    'placehoder' => 'Entrez le prix de la location par jour'
                ]
            ])
            ->add('voiture', EntityType::class, [
                'label' => 'Voiture',
                'class' => Voiture::class,
                'choice_label' => 'marque'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
