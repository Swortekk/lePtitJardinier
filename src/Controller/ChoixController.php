<?php

namespace App\Controller;

use App\Entity\User;

use Doctrine\Persistence\ManagerRegistry;
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
    public function index(ManagerRegistry $doctrine): Response
    {
        $session = new Session();

        if (!empty($this->getUser())) {
            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));



            $typeClient = $monUser->getTypeClient();
        } else {
            $typeClient = '';
        }




        return $this->render('choix/index.html.twig', [
            'controller_name' => 'ChoixController',

            'typeClient' => $typeClient,

        ]);
    }
}
