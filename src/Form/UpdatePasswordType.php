<?php

namespace App\Form;

use App\Entity\UpdatePassword;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('odlPassword', PasswordType::class, [
                'label' => 'Ancien mots de passe',
                'attr' => [
                    'placeholder' => "Entrez Votre mots de passe actuel"
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'label' => 'Nouveau mots de passe',
                'attr' => [
                    'placeholder' => "Entrez Votre nouveau mots de passe "
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
                'label' => 'Confirmation de mots de passe',
                'attr' => [
                    'placeholder' => "Comfirmer Votre nouveau mots de passe"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UpdatePassword::class,
        ]);
    }
}
