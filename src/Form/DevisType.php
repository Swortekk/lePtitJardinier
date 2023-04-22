<?php

namespace App\Form;

use App\Entity\Devis;
use App\Entity\Haie;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, ['attr' => ['class' => 'datetimepicker', 'placeholder' => 'Date'], 
            'label' => false])
            ->add('longueur', TextType::class, ['attr' => ['class' => 'form-control', 'placeholder' => 'Longueur'], 
            'label' => false])
            ->add('hauteur', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Hauteur'
                ],
                'label' => false
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'placeholder' => 'Sélectionnez un utilisateur',
                'attr' => ['class' => 'form-select'],
                'label' => false,

                // texte de placeholder
            ])
            ->add('haie', EntityType::class, [
                'class' => Haie::class,
                'placeholder' => 'Sélectionnez une haie',
                'attr' => ['class' => 'form-select'],
                'label' => false,

                // texte de placeholder
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Devis::class,
        ]);
    }
}
