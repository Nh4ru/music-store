<?php

namespace App\Controller\Backend;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    /**
     * UserController constructor
     *
     * @param UserRepository $repoUser
     */
    public function __construct(
        private UserRepository $repoUser
    ) {
    }

    #[Route('', name: 'admin.user.index')]
    public function indexUser(): Response
    {
        // Récuperer tous les users
        $users = $this->repoUser->findAll();

        return $this->render('Backend/User/index.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/{id}/delete', name: 'admin.user.delete', methods: ['POST'])]
    public function deleteUser(?User $user, Request $request): RedirectResponse
    {
        if (!$user instanceof User) {
            $this->addFlash('error', 'User not found');

            return $this->redirectToRoute('admin.user.index');
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->get('_token'))) {
            $this->repoUser->remove($user, true);

            $this->addFlash('success', 'Utilisateur supprimé avec succés');

            return $this->redirectToRoute('admin.user.index');
        }
    }

    #[Route('/{id}/edit', name: 'admin.user.edit')]
    /**
     * Page pour modifier les utilisateurs
     *
     * @param User|null $user
     * @param Request $request
     * @return Response|RedirectResponse
     */
    public function editUser(?User $user, Request $request): Response|RedirectResponse
    {
        if (!$user instanceof User) {
            $this->addFlash('error', "L'Id de l'utilisateur n'existe pas");
            return $this->redirectToRoute('admin.user.index');
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Envoi la modification du user en bdd
            $this->repoUser->add($user, true);

            // On ajoute un message du succès
            $this->addFlash('success', 'Utilisateur modifié avec succès');

            // On redirige vers la page liste des users
            return $this->redirectToRoute('admin.user.index');
        }

        // On envoi la vue de la page d'édition avec le formulaire
        return $this->renderForm('Backend/User/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }
}