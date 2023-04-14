<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoixController extends AbstractController
{
    /**
     * @Route("/choix", name="app_choix")
     */
    public function index(): Response
    {
        $request = Request::createFromGlobals();
        $choix = $request->get('choix');
        $session = new Session();
        $session->set('choix', $choix);

        $user = $this->getUser()->getTypeClient();

        return $this->render('choix/index.html.twig', [
            'controller_name' => 'ChoixController',
            'user' => $user,
        ]);



    }
}