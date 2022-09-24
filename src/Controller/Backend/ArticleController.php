<?php

namespace App\Controller\Backend;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/admin")]
class ArticleController extends AbstractController
{
    public function __construct(
        private ArticleRepository $repoArticle
    ) {
    }

    #[Route('', name: 'admin')]
    public function index(): Response
    {
        // Récupérer tous les articles
        $articles = $this->repoArticle->findAll();

        return $this->render('Backend/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}