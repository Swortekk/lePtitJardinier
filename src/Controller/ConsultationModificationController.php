<?php

namespace App\Controller;

use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConsultationModificationController extends AbstractController
{
    /**
     * @Route("/consultation/modification", name="app_consultation_modification")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $mesHaies = $doctrine->getRepository(Haie::class)->findAll();

        return $this->render('consultation_modification/index.html.twig', [
            'controller_name' => 'ConsultationModificationController',
            'mesHaies' => $mesHaies,
        ]);
    }
}