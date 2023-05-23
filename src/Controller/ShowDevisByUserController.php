<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Devis;
use App\Repository\DevisRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ShowDevisByUserController extends AbstractController
{
    /**
     * @Route("/show/devis/by/user", name="app_show_devis_by_user")
     */
    public function index(ManagerRegistry $doctrine): Response
    {


        if (!empty($this->getUser())) {

            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
            $devisRepository = $doctrine->getRepository(Devis::class);

            $listeDevis = $devisRepository->findBy(array('user' => $monUser));
        } else {

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }



        // ou ça     
        // $listeDevis = $devisRepository->findBy(['user' => $monUser->getId()]);




        return $this->render('show_devis_by_user/index.html.twig', [
            'controller_name' => 'ShowDevisByUserController',
            'listeDevis' => $listeDevis,
            'monUser' => $monUser,

        ]);
    }



}