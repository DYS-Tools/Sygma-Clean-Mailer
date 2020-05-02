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
        ]);
    }

    /**
     * @Route("/order", name="order")
     */
    public function BuyApplicationWithOrder(payment $payment, Request $request)
    {
    
        Stripe::setApiKey($payment->getStripeSecretCredentials());
        
            //TODO: Create success and cancel URL and redirect payment
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                  'name' => 'T-shirt',
                  'description' => 'Comfortable cotton t-shirt',
                  'images' => ['https://example.com/t-shirt.png'],
                  'amount' => 500,
                  'currency' => 'eur',
                  'quantity' => 1,
                ]],
                'success_url' => 'https://SpeedMailer/sucessURL',
                'cancel_url' => 'https://SpeedMailer/cancelURL',
              ]);
        
        return $this->render('order/order.html.twig', [
            'stripe_public_key' => $payment->getStripePublicCredentials(),
            'CHECKOUT_SESSION_ID' => $session['id']
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
