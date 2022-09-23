<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Classe Main pour controler la page d'Accueil
 */
class MainController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        // On demande au controller d'envoyer la vue Home
        $data = ['Pierre', 'Paul', 'Jacques'];
        return $this->render('Home/index.html.twig', [
            'data' => $data
        ]);
    }
}