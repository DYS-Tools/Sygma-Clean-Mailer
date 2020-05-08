<?php

namespace App\Controller;

use App\Entity\ListMail;
use App\Form\EmailFormType;
use App\Form\ListFormType;
use App\Form\cleanOptionsFormType;
use App\Service\clean;
use App\Service\extractListInformation;
use App\Service\upload;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class cleanController extends AbstractController
{
    /**
     * @Route("/lists", name="lists")
     */
    public function lists(Request $request, EntityManagerInterface $entityManager, upload $upload,extractListInformation $extract)
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
            $listmail->setContact($emailNumber);
            $entityManager->persist($listmail);

            $entityManager->flush();

            $this->addFlash('info', $emailNumber .' contact has been imported');
            $this->redirectToRoute('lists');
        }

        return $this->render('lists.html.twig', [
            'listForm' => $form->createView(),
            'lists' => $lists,

        ]);
    }

    /**
     * @Route("/clean", name="clean")
     */
    public function clean(Request $request, clean $clean, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form['email']->getData();
        }

        $formList = $this->createForm(cleanOptionsFormType::class);
        $formList->handleRequest($request);

        if ($formList->isSubmitted() && $formList->isValid()) {
            $list = $formList['listSelect']->getData();
            $severalMode = $formList['severe']->getData();

            $user = $this->getUser();
            $deletemailNumber = $clean->CleanMailingList($list,$severalMode);

            $user->setMailCredit($user->getMailCredit() - $deletemailNumber);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('info', $deletemailNumber .' contact has deleted');
            

        }

        return $this->render('clean.html.twig', [
            'emailForm' => $form->createView(),
            'listOptionForm' => $formList->createView(),
        ]);
    }

    /**
     * @Route("/pricing", name="pricing")
     */
    public function pricing()
    {
        //$form = $this->createForm(addTricksFormType::class,$trick);
        //$form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
        //$upload->upload($Illustration->getFile());
        //}

        return $this->render('pricing.html.twig', [

        ]);
    }
}
