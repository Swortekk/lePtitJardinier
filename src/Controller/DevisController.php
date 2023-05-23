<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Haie;
use App\Entity\User;

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
        if ($type == "") {
            return $this->redirectToRoute('app_mesure');
        }

        $maHaie = $doctrine->getRepository(Haie::class)->find($type);

        if (!empty($this->getUser())) {

            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
            $typeClient = $monUser->getTypeClient();

        } else {
            $typeClient = "";
        }


        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'typeClient' => $typeClient,
            'maHaie' => $maHaie

        ]);



    }
}