<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\EntityManagerInterface;


class AccueilController extends AbstractController
{
    /**
     * @Route("/", name="app_accueil")
     */
    public function index()
    {
        // On vérifie bien que l'utilisateur est un admin pour lui donner accés au backoffice si besoin
        $user = $this->getUser();


        if (true === $this->isGranted('ROLE_ADMIN')) {
           $admin = "OK";
        }
        // On vérifie bien que l'utilisateur est un étudiant pour lui donner accès à la partie upload 

        else if (true === $this->isGranted('ROLE_USER')) {
           $etudiant = "OK";
        } 

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'user' => $user
        ]);
    }
}
