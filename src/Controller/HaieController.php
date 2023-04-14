<?php

namespace App\Controller;

use App\Entity\Haie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class HaieController extends AbstractController
{


    /**
     * @Route("/haie/creer", name="creer_haie")
     */


    public function creer_haie(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $categorie = new Categorie();
        $categorie->setLibelle('Persistant');

        $haie = new Haie();
        $haie->setCode('LA');
        $haie->setNom('Laurier');
        $haie->setPrix(30);

        $entityManager->persist($haie);
        $entityManager->flush();
        return new Response('Type de haie créé avec le code ' . $haie->getCode() . ' et nouvelle catégorie avec id: ' . $categorie->getId());
    }

    /**
     * @Route("/haie/{code}", name="voir_haie")
     */
    public function voir_haie(ManagerRegistry $doctrine, string $code): Response
    {
        $haie = $doctrine->getRepository(Haie::class)->find($code);

        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas : ' . $code);
        } else {
            return new Response('Type de haie : ' . $haie->getNom() . ' à ' . $haie->getPrix() . '€');
        }
    }


    /**
     * @Route("/haie/modifier/{code}", name="modifier_haie")
     */
    public function modifier_haie(ManagerRegistry $doctrine, string $code): Response
    {


        $entityManager = $doctrine->getManager();
        $haie = $doctrine->getRepository(Haie::class)->find($code);

        $haie->setPrix(42);
        $entityManager->flush();

        return $this->redirectToRoute('voir_haie', ['code' => $haie->getCode()]);
    }

    /**
     * @Route("/haie/supprimer/{code}", name="supprimer_haie")
     */
    public function supprimer_haie(ManagerRegistry $doctrine, string $code): Response
    {
        $entityManager = $doctrine->getManager();
        $haie = $doctrine->getRepository(Haie::class)->find($code);

        $entityManager->remove($haie);
        $entityManager->flush();

        return new Response('La haie a été supprimé ');


    }



    /**
     * @Route("/haie", name="haie")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $maHaie = $doctrine->getManager();
        return $this->render('haie/index.html.twig', [
            'controller_name' => 'HaieController',

        ]);
    }
}