<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('center', HiddenType::class, [
            'label' => 'Centre séléctionner',
            'disabled' => false,
            'required' => true
            ])
            ->add('name', TextType::class,[
                'label' => 'Votre Nom et Prénom'
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre E-mail'
            ])
            ->add('phone', TelType::class,[
                'label' => 'Téléphone',
                'attr' => [
                    'pattern' => '^0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                    'maxlength' => 14,
                    'placeholder' => 'Exemple : 01 23 45 67 89'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Décrivez votre problème'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'=> Contact::class
        ]);
    }
}