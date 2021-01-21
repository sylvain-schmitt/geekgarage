<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
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
                'label' => 'Votre Nom',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Votre e-mail',
            ])
            ->add('subject', TextType::class, [
                'label' => 'Sujet du message',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Votre message',
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