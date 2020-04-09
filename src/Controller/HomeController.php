<?php

namespace App\Controller;

use App\Form\SendMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->render('home.html.twig', [
        ]);
    }

    /**
     * @Route("/mail", name="mail")
     */
    public function mail(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(SendMailType::class);
        $form->handleRequest($request);

        $name = $request->request->get('Name');;
        $email = $request->request->get('Email');
        $object = $request->request->get('Subject');
        $msg = $request->request->get('Message');

        if ($form->isSubmitted() && $form->isValid()) {
            $message = (new \Swift_Message($object))
                ->setFrom($form->get($email)->getData())
                ->setTo('sacha6623@gmail.com')
                ->setBody($msg);

            $mailer->send($message);

            $this->addFlash('info', "Email has been send");

        return $this->render('mail.html.twig', [
            'EmailForm' => $form->createView(),
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
