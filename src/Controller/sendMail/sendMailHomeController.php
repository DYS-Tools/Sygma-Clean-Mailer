<?php

namespace App\Controller\sendMail;

use App\Form\sendMail\SendMailType;
use App\Form\SettingUserFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class sendMailHomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('sendMail/home.html.twig', [
        ]);


    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request)
    {
        /* REFAIRE AVEC LE COMPOSANT MAILER */
        $form = $this->createForm(SendMailType::class);
        $form->handleRequest($request);

        $name = $form->get('Name')->getData();
        $email = $form->get('Email');
        $object = $form->get('Subject')->getData();
        $msg = $form->get('Message')->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            /*
            $message = (new \Swift_Message($object))
                ->setFrom($form->get('Email')->getData())
                ->setTo('sacha6623@gmail.com')
                ->setBody($msg);

            $mailer->send($message);
            */

            $this->addFlash('info', "Email has been send");
        }

        return $this->render('mail.html.twig', [
            'EmailForm' => $form->createView(),
        ]);
    }


    /**
     * @Route("/settings", name="setting")
     */
    public function setting(Request $request)
    {
        $form = $this->createForm(SettingUserFormType::class);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $host = $form->get('Name')->getData();


            // $user->set Parameters for mailing
            return $this->redirectToRoute('home');

        }

        return $this->render('security/setting.html.twig', [
            'SettingForm' => $form->createView(),

        ]);
    }

    /**
     * @Route("/list/single/", name="list-single")
     */
    public function listSingle()
    {

        return $this->render('list-single.html.twig', [
        ]);
    }
}
