<?php

namespace App\Controller;

use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MesureController extends AbstractController
{
    /**
     * @Route("/mesure", name="app_mesure")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {

        $req = Request::createFromGlobals();
        $session = new Session();

        $choix = $req->get('choix');
    
        $typeClient = $session->set('typeClient', $choix);

        $mesHaies = $doctrine->getRepository(Haie::class)->findAll();

        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'MesureController',
            'mesHaies' => $mesHaies,
        ]);


    }


}