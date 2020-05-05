<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\PaymentFormType;
use App\Service\payment;
use Doctrine\Common\Persistence\ObjectManager;
use Stripe\Charge;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\HttpClient\HttpClient;

class OrderController extends AbstractController
{

    /**
     * @Route("/offer", name="offer")
     */
    public function offer(payment $payment)
    {
        return $this->render('order/offer.html.twig', [
            'stripe_public_key' => $payment->getStripePublicCredentials(),
        ]);
    }

    /**
     * @Route("/order/{offer}", name="order")
     */
    public function BuyApplicationWithOrder(payment $payment, Request $request, $offer)
    {
        // get current user
        $user = $this->getUser() ;

        Stripe::setApiKey($payment->getStripeSecretCredentials());
            if($offer == 'Simple'){
                // create order
                $order = new Order();
                $order->setAmount(9);
                $order->setStatus("En attande de paiement");
                $order->setUser($user);
                $order->setCreatedAt( new \DateTime() );
               // $manager->persist($order);
               // $manager->flush();

                $session = $payment->makePayment(9,'Offre Simple');

                // le statue de la session de stripe // if payment ok statut order = payé, if echec = echec
                // si la session est payer on crédite les mail
            }
            if($offer == 'Pro'){
                $session = $payment->makePayment(15,'Offre Pro');
            }
            if($offer == 'Entreprise'){
                $session = $payment->makePayment(30,'Offre Entreprise');
            }

        return $this->render('order/order.html.twig', [
            'stripe_public_key' => $payment->getStripePublicCredentials(),
            'CHECKOUT_SESSION_ID' => $session['id'],
            'offer' => $offer
        ]);
    }

    /**
     * @Route("/StateOfPayment/{state}", name="StateOfPayment")
     */
    public function StateOfPayment(payment $payment, $state){
                
        return $this->render('order/stateOfPayment.html.twig', [
            'state' => $state
        ]);
        
    }
}
