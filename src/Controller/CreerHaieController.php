<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Haie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;

class CreerHaieController extends AbstractController
{
    /**
     * @Route("/creer/haie", name="app_creer_haie")
     */


    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();
        $haie = new Haie();
        $form = $this->createFormBuilder($haie)
            ->add('code', TextType::class, array('label' => 'Code haie', ))
            ->add('nom', TextType::class, array('label' => 'Nom haie'))
            ->add('prix', NumberType::class, array('label' => 'Tarif haie', 'invalid_message' => 'Saisir un nombre'))
            ->add('categorie', EntityType::class, [
                'label' => 'Categorie haie',
                'class' => Categorie::class,
                'choice_label' => 'libelle',
                'attr' => ['class' => 'form-select']
            ])
            ->add(
                'save', SubmitType::class,
                array(
                    'label' => 'Ajouter',
                    'attr' => ['class' => 'btn btn-success']
                )
            )
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($haie);
            $entityManager->flush();
        }

        return $this->render(
            'creer_haie/index.html.twig',
            array('form' => $form->createView())
        );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Haie::class,
        ]);
    }
}