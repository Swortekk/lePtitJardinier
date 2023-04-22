<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      
        ->add('nom', TextType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'Nom'],
            'label' => false
           
        ])
        ->add('prenom', TextType::class, [
            'attr' => ['class' => 'form-control',   'placeholder' => 'Prénom'],
            'label' => false
            
        ])
        ->add('email', EmailType::class, [
            'attr' => ['class' => 'form-control', 'placeholder' => 'E-mail'],
            'label' => false
         
           
        ])
        ->add('adresse', TextType::class, [
            'attr' => ['class' => 'form-control',  'placeholder' => 'Adresse'],
            'label' => false
       
        ])
        ->add('ville', TextType::class, [
            'attr' => ['class' => 'form-control',  'placeholder' => 'Ville'],
            'label' => false
          
        ])
        ->add('cp', TextType::class, [
            'attr' => ['class' => 'form-control',  'placeholder' => 'Code Postale'],
            'label' => false
            
        ])

        ->add('typeClient', ChoiceType::class, [
    
            'choices' => [
                'Particulier' => 'P',
                'Entreprise' => 'E',
            ],
            'placeholder' => 'Selectionner un type de client',
         
            'multiple' => false,
            'required' => true, 
            'attr' => ['class' => 'form-select lg'],
            'label' => false
        ])
        ->add('plainPassword', PasswordType::class, [
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            'mapped' => false,
            'label' => false,
            'attr' => ['autocomplete' => 'new-password', 'class' => 'form-control', 'placeholder' => 'Mot de passe'],

            'constraints' => [
                new NotBlank([
                    'message' => 'Please enter a password',
                    
                ]),
                new Length([
                    'min' => 6,
                    'minMessage' => 'Your password should be at least {{ limit }} characters',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
