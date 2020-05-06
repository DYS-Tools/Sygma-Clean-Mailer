<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\GetEmailFormType;
use App\Form\RegistrationFormType;
use App\Form\ResetPasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //if ($this->getUser()) {
             //return $this->redirectToRoute('home');
         //}

        //$this->getUser();
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 'error' => $error
            ]);
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(\Swift_Mailer $mailer, Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setPassword( $passwordEncoder->encodePassword( $user,  $form->get('plainPassword')->getData() ));
            $user->setEmail($form->get('email')->getData());

            $token = bin2hex(random_bytes(13));
            $user->setToken($token);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $message = (new \Swift_Message('Activate your account'))
            ->setFrom('sacha6623@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView( 'emails/signup.html.twig', [
                    'name' => $user->getUsername(),
                    'user' => $user
                    ]),
                'text/html'
            )
            ;
            $mailer->send($message);


            $this->addFlash('info', "Bienvenue, pensez a verifier votre compte a l'aide de votre boite mail");
            return $this->redirectToRoute('home');
        }

        return $this->render('security/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/activate/{token}", name="activate_account")
     */
    public function activateAccount($token, EntityManagerInterface $entityManager){
        $repositoryUser = $this->getDoctrine()->getRepository(User::class);
        $user = $repositoryUser->findOneBytoken($token);
        
        if($user->getToken() === $token) {
            $user->setToken('1');
            $entityManager->persist($user);
            $entityManager->flush();
        }
        $this->addFlash('info', "Votre compte a été vérifié");
        return $this->redirectToRoute('home');

    }

    /**
     * @Route("/resetPassword", name="reset_password")
     */
    public function resetPassword(Request $request, EntityManagerInterface $entityManager, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(GetEmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $token = bin2hex(random_bytes(13));
            $repository = $this->getDoctrine()->getRepository(User::class);
            $user = $repository->findOneBy(array('email' => $form->get('Email')->getData())); // trouver l'adresse mail POST du FORM
            $user->setToken($token);
            $entityManager->persist($user);
            $entityManager->flush();

            $message = (new \Swift_Message('Reset password'))
                ->setFrom('sacha6623@gmail.com')
                ->setTo($form->get('Email')->getData())
                ->setBody(
                    $this->renderView(
                        'emails/resetPassword.html.twig',
                        ['token' => $token, 'user' => $user ]), 'text/html'
                )
            ;
            $mailer->send($message);
            $this->addFlash('info', "Email has been send");
        }
        return $this->render('security/reset.html.twig', [ 'resetForm' => $form->createView(), ]);
    }

    /**
     * @Route("/resetPassword/{token}", name="reset_password_with_token")
     */
    public function resetPasswordWithToken(Request $request, $token, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder){
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $repository->findOneBytoken($token);
        $form = $this->createForm(ResetPasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if($user->getToken() === $token) {
                $user->setPassword($encoder->encodePassword($user, $form->get('password')->getData()));
                $user->setToken('1');
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash( 'info', "password updated !");
                return $this->redirectToRoute('home');
            }
        } 
        return $this->render('security/changePassword.html.twig', [
            'changePasswordForm' => $form->createView(),
        ]);

    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}