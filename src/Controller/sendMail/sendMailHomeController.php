<?php

namespace App\Controller\sendMail;

use App\Entity\ListMail;
use App\Form\sendMail\ListFormType;
use App\Form\sendMail\SendMailType;
use App\Form\SettingUserFormType;
use App\Service\sendMailService\extractListInformation;
use App\Service\sendMailService\upload;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;



class sendMailHomeController extends AbstractController
{
    /**
     * @Route("/sendMail", name="sendmail")
     */
    public function home(Request $request, EntityManagerInterface $entityManager, upload $upload, extractListInformation $extract)
    {
        $ListRepo = $this->getDoctrine()->getRepository(ListMail::class);
        $lists = $ListRepo->findBy(['user' => $this->getUser()]);
        $form = $this->createForm(ListFormType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $file = $form['file']->getData();
            $fileName = $upload->upload($file);


            $listmail = new ListMail();
            $listmail->setUser($this->getUser());
            $listmail->setName($form['name']->getData());
            $listmail->setPath($fileName);

            $entityManager->persist($listmail);

            $emailNumber = $extract->ExtractDataInDocument($fileName,$listmail);
            //$emailNumber = 20;
            $listmail->setContact($emailNumber);
            $entityManager->persist($listmail);

            $entityManager->flush();

            $this->addFlash('info', $emailNumber .' contact has been imported');
            $this->redirectToRoute('sendmail');
        }

        return $this->render('sendMail/home.html.twig', [
            'listForm' => $form->createView(),
            'lists' => $lists,
        ]);

    }

    /**
     * @Route("/mailTemplate", name="mailTemplate")
     */
    public function mailTemplate(){
        return $this->render('sendMail/mailTemplate.html.twig', [
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

        return $this->render('sendMail/mail.html.twig', [
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
