<?php

namespace App\Controller;

use App\Service\payment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(payment $payment )
    {
        return $this->render('home.html.twig', [
            'stripe_public_key' => $payment->getStripePublicCredentials(),
        ]);
    }

    /**
     * @Route("/faq", name="app_faq")
     */
    public function faq()
    {
        return $this->render('faq.html.twig', [
        ]);
    }

    /**
     * @Route("/legal", name="app_legal")
     */
    public function legal()
    {
        return $this->render('legal.html.twig', [
        ]);
    }
}
