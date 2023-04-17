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
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {


        $req = Request::createFromGlobals();

        $session = $request->getSession();
        $longueur = $req->get('txtLongueur');
        $hauteur = $req->get('txtHauteur');
        $type = $req->get('txtType');

        $session->set('hauteur', $hauteur);
        $session->set('longueur', $longueur);
        $session->set('typeHaie', $type);


        $maHaie = $doctrine->getRepository(Haie::class)->find($type);
        
        $typeClient = $session->get('typeClient');
   


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'typeClient' =>  $typeClient,
            'maHaie' => $maHaie

        ]);



    }
}