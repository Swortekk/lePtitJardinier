<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Haie;

class DevisController extends AbstractController
{
    /**
     * @Route("/devis", name="app_devis")
     */
    public function index(ManagerRegistry $doctrine): Response
    {


        $request = Request::createFromGlobals();


        $longueur = $request->get('txtLongueur');
        $hauteur = $request->get('txtHauteur');
        $type = $request->get('txtType');


        $session = new Session();


        $user = $session->get('user');
        $longueur_session = $session->set('longueur', $longueur);
        $hauteur_session = $session->set('hauteur', $hauteur);
        $typeHaie_session = $session->set('typeHaie', $type);

        $maHaie = $doctrine->getRepository(Haie::class)->find($type);


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'user' => $user,
            'maHaie' => $maHaie

        ]);



    }
}