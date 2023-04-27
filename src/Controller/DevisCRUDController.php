<?php

namespace App\Controller;

use App\Entity\Devis;
use App\Entity\User;
use App\Form\DevisType;
use App\Repository\DevisRepository;
use DateTime;
use DateTimeZone;
use Doctrine\Persistence\ManagerRegistry;
use IntlDateFormatter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/devis/c/r/u/d")
 */
class DevisCRUDController extends AbstractController
{
    /**
     * @Route("/", name="app_devis_c_r_u_d_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN", message="vous n'avez pas les droits pour accéder à cette page")
     */
    public function index(DevisRepository $devisRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();




        return $this->render('devis_crud/index.html.twig', [
            'devis' => $devisRepository->getAllDevisInformations(),
        ]);
    }

    /**
     * @Route("/new", name="app_devis_c_r_u_d_new", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN", message="vous n'avez pas les droits pour accéder à cette page")
     */
    public function new(Request $request, DevisRepository $devisRepository): Response
    {
        $devi = new Devis();
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devi, true);

            return $this->redirectToRoute('app_devis_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devis_crud/new.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_devis_c_r_u_d_show", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN') or is_granted('ROLE_USER')")
     */
    public function show(DevisRepository $devisRepository, Devis $devi, ManagerRegistry $doctrine): Response
    {
        if (!empty($this->getUser())) {

            $mail = $this->getUser()->getUserIdentifier();
            $monUser = new User();
            $monUser = $doctrine->getRepository(User::class)->findOneBy(array('email' => $mail));
        }
        $monDevis = $devisRepository->getDevisInformationById($devi);

        $date = $monDevis[0]['date']; // en supposant que la date est stockée en tant qu'objet DateTime dans la base de données
        $date->setTimezone(new DateTimeZone('Europe/Paris')); // définir le fuseau horaire à Paris
        $formatter = new IntlDateFormatter('fr_FR', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $dateString = $formatter->format($date); // Résultat : "18 avril 2023"

        $typeClient = $monDevis[0]['type_client'];


        return $this->render('devis_crud/show.html.twig', [
            'monDevis' => $monDevis,
            'date' => $dateString,
            'typeClient' => $typeClient,
            'devi' => $devi,
            'monUser' => $monUser

        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_devis_c_r_u_d_edit", methods={"GET", "POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Devis $devi, DevisRepository $devisRepository): Response
    {
        $form = $this->createForm(DevisType::class, $devi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $devisRepository->add($devi, true);

            return $this->redirectToRoute('app_devis_c_r_u_d_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('devis_crud/edit.html.twig', [
            'devi' => $devi,
            'form' => $form,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/{id}", name="app_devis_c_r_u_d_delete", methods={"POST"})
     */
    public function delete(Request $request, Devis $devi, DevisRepository $devisRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $devi->getId(), $request->request->get('_token'))) {
            $devisRepository->remove($devi, true);
        }

        return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
    }




}