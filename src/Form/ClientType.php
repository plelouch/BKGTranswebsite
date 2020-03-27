<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class,[
                'label' => 'Nom ',
                'attr' => [
                    'placeholder' => "Saisire nom du client"
                ]
            ])
            ->add('prenom', TextType::class,[
                'label' => 'Prénom ',
                'attr' => [
                    'placeholder' => "Saisire prénom du client"
                ]
            ])
            ->add('adresse', TextType::class,[
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => "Saisire l'adresse du client"
                ]
            ])
            ->add('numCin', IntegerType::class,[
                'label' => 'Numéros de carte d\'identité',
                'attr' => [
                    'placeholder' => "Saisire numéros de carte d'identité du client"
                ]
            ])
            ->add('dateNaiss', BirthdayType::class,[
                'label' => 'Date de naissance',
                'widget' => 'single_text'
            ])
            ->add('lieuNaiss', TextType::class,[
                'label' => 'Lieu de naissance',
                'attr' => [
                    'placeholder' => "Saisire le lieu de naissance du client"
                ]
            ])
            ->add('contact', IntegerType::class,[
                'label' => 'numéros de téléphone',
                'attr' => [
                    'placeholder' => "Saisire numéros de téléphone du client"
                ]
            ])
            ->add('numPermis', IntegerType::class,[
                'label' => 'Numéros de permit',
                'attr' => [
                    'placeholder' => "Saisire numéros de permit du client"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
