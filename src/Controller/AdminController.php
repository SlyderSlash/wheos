<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route("/utilisateurs", name: "utilisateurs")]
    public function usersList(UsersRepository $users)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route("/utilisateurs/modifier/{id}", name: "modifier_utilisateur")]
    public function editUser(Users $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('utilisateurs');
        }
        
        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
