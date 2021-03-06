<?php

namespace App\Form;

use App\Entity\Agency;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgencyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('city', TextType::class,[
                'label' => 'Ville',
            ])
            ->add('number', TelType::class,[
                'label' => 'Téléphone',
                'attr' => [
                    'pattern' => '^0[0-9]{1} [0-9]{2} [0-9]{2} [0-9]{2} [0-9]{2}',
                    'maxlength' => 14,
                    'placeholder' => 'Exemple : 01 23 45 67 89'
                ]
            ])
            ->add('mail', EmailType::class,[
                'label' => 'E-Mail',
            ])
            
            ->add('address', TextType::class,[
                'label' => 'Address',
            ])
            ->add('comment', TextareaType::class,[
                'label' => 'Commentaire',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Agency::class,
        ]);
    }
}
