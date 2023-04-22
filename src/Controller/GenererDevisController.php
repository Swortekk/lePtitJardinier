<?php

namespace App\Controller;



use App\Entity\user;
use App\Entity\Devis;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class GenererDevisController extends AbstractController
{
    /**
     * @Route("/generer/devis", name="app_generer_devis")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {

        $session = $request->getSession();

        $entityManager = $doctrine->getManager();

        $typeHaie = $session->get('typeHaie');
        $longueur = $session->get('longueur');
        $hauteur = $session->get('hauteur');


        $maHaie = $doctrine->getRepository(Haie::class)->find($typeHaie);


        if (!empty($this->getUser())) {

            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
          

            $devis = new Devis();
            $devis->setUser($monUser);
            $devis->setHaie($maHaie);
            $devis->setHauteur($hauteur);
            $devis->setLongueur($longueur);


            $date = new DateTime('now');
            $devis->setDate($date);

            $entityManager->persist($devis);
            $entityManager->flush();

            return $this->render('generer_devis/index.html.twig', [
                'controller_name' => 'GenererDevisController',
                'user' => $monUser,
        
             

            ]);
        }
    }
}
