<?php

namespace App\Form;

use App\Entity\Type;
use App\Entity\Voiture;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('matricule', IntegerType::class,[
                'label' => 'Numéros d\'immatriculation',
                'attr' => [
                    'placeholder' => "Saisir le numéros d'immatriculation de la voiture"
                ]
            ])
            ->add('dateDrive', DateType::class,[
                'label' => 'Date de circulation',
            ])
            ->add('modele', TextType::class,[
                'label' => 'Modèle',
                'attr' => [
                    'placeholder' => "Saisir le Modèle de la voiture"
                ]
            ])
            ->add('compteur', IntegerType::class,[
                'label' => 'Numéros du compteur',
                'attr' => [
                    'placeholder' => "Saisir le numéros du compteur de la voiture"
                ]
            ])
            ->add('marque', TextType::class,[
                'label' => 'Marque',
                'attr' => [
                    'placeholder' => "Saisir la Marque de la voiture"
                ]
            ])
            ->add('couleur', ColorType::class,[
                'label' => 'Couleur de la voiture',
            ])
            ->add('isDispo', ChoiceType::class,[
                'label' => 'Disponibiliter',
                'choices' =>[
                    'Oui' => true,
                    'Non' => false,
                ]
            ])
            ->add('image', FileType::class,[
                'data_class' => null,
                'label' => 'Image de la voiture',
            ])
            ->add('type', EntityType::class,[
                'class' => Type::class,
                'choice_label' => 'name'
            ])
            ->add('infosups', CollectionType::class,[
                'entry_type' => InfovoitureType::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Voiture::class,
        ]);
    }
}
