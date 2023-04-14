<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Haie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\Persistence\ManagerRegistry;


class ModifierHaieController extends AbstractController
{
    /**
     * @Route("/modifier/haie", name="app_modifier_haie")
     */
    public function index(ManagerRegistry $doctrine, Request $request): Response
    {
        $request = Request::createFromGlobals();
        $code = $request->get('code');


        $maHaie = new Haie();

        $maHaie = $doctrine->getRepository(Haie::class)->find($code);

        $form = $this->createFormBuilder($maHaie)
            ->add('code', TextType::class, array('label' => 'Code haie'))
            ->add('nom', TextType::class, array('label' => 'Nom haie'))
            ->add('prix', NumberType::class, array('label' => 'Tarif haie', 'invalid_message' => 'Saisir un nombre'))
            ->add('save', SubmitType::class, array('label' => 'Modifier', 'attr' => ['class' => 'btn btn-success']))
            ->getForm();


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $doctrine->getManager();
            $entityManager->persist($maHaie);
            $entityManager->flush();
        }

        return $this->render(
            'modifier_haie/index.html.twig',
            array(
                'form' => $form->createView(),
            )

        );

    }


}