<?php

namespace App\Form;

use App\Entity\Property;
use App\Entity\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre de la propriété',
                'attr' => [
                    'placeholder' => "Saisir un titre pour la propriété"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Décrire la propriété',
                'attr' => [
                    'placeholder' => "Saisir une description sur la propriété"
                ]
            ])
            ->add('surface', IntegerType::class, [
                'label' => 'Surface de la propriété',
                'attr' => [
                    'placeholder' => "Saisir la surface sur laquel est construit la propriété"
                ]
            ])
            ->add('rooms', IntegerType::class, [
                'label' => 'Nombre pièce de la propriété',
                'attr' => [
                    'placeholder' => "Saisir le nombre de pièce(s) que contient la propriété"
                ]
            ])
            ->add('bedrooms', IntegerType::class, [
                'label' => 'Nombre chambre(s) de la propriété',
                'attr' => [
                    'placeholder' => "Saisir le nombre de chambre(s) que contient la propriété"
                ]
            ])
            ->add('floor', IntegerType::class, [
                'label' => 'Nombre d\'étage de la propriété',
                'attr' => [
                    'placeholder' => "Saisir le nombre d'étage(s) que contient la propriété"
                ]
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix de la propriété',
                'attr' => [
                    'placeholder' => "Saisir le prix de vente ou de location la propriété"
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville de la propriété',
                'attr' => [
                    'placeholder' => "Saisir la ville ou se trouve la propriété"
                ]
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse de la propriété',
                'attr' => [
                    'placeholder' => "Saisir l'adresse ou se trouve la propriété"
                ]
            ])
            ->add('sold', ChoiceType::class, [
                'label' => 'Status de la propriété',
                'choices' => [
                    'Vendue' => true,
                    'Loué' => true,
                    'Toujours disponible' => false
                ]
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'choice_label' => 'name'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de la propriété',
                'data_class' => null
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
