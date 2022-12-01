<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\UsersAuthenticator;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, UserAuthenticatorInterface $userAuthenticator, UsersAuthenticator $authenticator, EntityManagerInterface $entityManager, SendMailService $mail, JWTService $jwt): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
            $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            // on génère le jwt de l'utilisateur
            // on crée le header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            // on crée le payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // on génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));



            // on envoie un mail
            $mail->send(
                'no-reply@wheos.fr',
                $user->getEmail(),
                'Activation de vôtre compte',
                'register',
                compact('user', 'token')
                );



            return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser($token, JWTService $jwt, UsersRepository $usersRepository, EntityManagerInterface $em): Response
    {
        // on vérifie si le token est valide, n'a pas expiré et n'a pas été modifié
        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))){
            // on récupère le payload
            $payload = $jwt->getPayload($token);

            // on récupère le user du token
            $user = $usersRepository->find($payload['user_id']);

            // on vérifie que l'utilisateur existe et n'a pas encore activé son compte
            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('app_main');
            }
        }
        // problème dans le token
        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoieverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UsersRepository $usersRepository): Response
    {
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Vous n\'êtes pas connecté');
            return $this->redirectToRoute('app_login'); 
        }
        if ($user->getIsVerified()) {
            $this->addFlash('danger', 'Utilisateur déjà activé');
            return $this->redirectToRoute('app_main');
        }

            // on génère le jwt de l'utilisateur
            // on crée le header
            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            // on crée le payload
            $payload = [
                'user_id' => $user->getId()
            ];

            // on génère le token
            $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));



            // on envoie un mail
            $mail->send(
                'no-reply@monsite.fr',
                $user->getEmail(),
                'Activation de vôtre compte',
                'register',
                compact('user', 'token')
                );
                
            $this->addFlash('danger', 'E-mail renvoyer.');
            return $this->redirectToRoute('app_main');
    }
}