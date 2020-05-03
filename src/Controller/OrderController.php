<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\PaymentFormType;
use App\Service\payment;
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

        Stripe::setApiKey($payment->getStripeSecretCredentials());
        
            if($offer == 'Simple'){
                $session = $payment->makePayment(5,'Offre Simple');
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
