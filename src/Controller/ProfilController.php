<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\TravauxRepository;
use App\Entity\Travaux;

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(TravauxRepository $repo): Response
    {

        $em = $this->getDoctrine()->getManager();
        $travaux = $em->getRepository(Travaux::class)->findAll();

        return $this->render('profil/index.html.twig', [
            'travaux' => $repo->findAll(),

        ]);
    }
}
