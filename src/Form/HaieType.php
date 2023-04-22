<?php

namespace App\Form;

use App\Entity\Haie;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HaieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Code',],
                'label' => false,
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control', 'placeholder' => 'Nom',],
                'label' => false,
            ])
            ->add('prix', TextType::class, [
                'attr' => ['class' => 'form-control',   'placeholder' => 'Prix'],
                'label' => false,
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'placeholder' => 'Sélectionnez une catégorie de haie',
                'attr' => ['class' => 'form-select'],
                'label' => false,

                // texte de placeholder
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Haie::class,
        ]);
    }
}
