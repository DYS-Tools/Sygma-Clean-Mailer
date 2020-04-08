<?php

namespace App\Controller;

use App\Form\SendMailType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function mail()
    {
        //$form = new SendMailType();

        return $this->render('mail.html.twig', [
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
