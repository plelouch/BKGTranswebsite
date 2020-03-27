<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class,[
                'label' => 'Nom d\'utilisateur',
                'attr' => [
                    'placeholder' => 'Saisisez votre nom d\'utilisateur'
                ]
            ])
            ->add('confirmpass', PasswordType::class,[
                'label' => 'Confirmer Mots de passe',
                'attr' => [
                    'placeholder' => 'Saisisez votre mots de passe de confirmation'
                ]
            ])
            ->add('password', PasswordType::class,[
                'label' => 'Mots de passe',
                'attr' => [
                    'placeholder' => 'Saisisez votre mots de passe'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
