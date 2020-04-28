<?php

namespace App\Controller;


use App\Service\payment;
use Stripe\Stripe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\NotBlank;

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
        $number = 50.00;
        $payment->makePayment(5);

        // Payment Card For Testing : 4242424242424242
        Stripe::setApiKey($payment->getStripeSecretCredentials());

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'name' => 'Speed Mailer',
                'description' => 'Comfortable cotton t-shirt',
                'images' => ['https://example.com/t-shirt.png'],
                'amount' => $number,
                'currency' => 'eur',
                'quantity' => 1,
            ]],
            'success_url' => 'https://example.com/success?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'https://example.com/cancel',
        ]);


        return $this->render('order/order.html.twig', [
            'stripe_secret_key' => $payment->getStripeSecretCredentials(),
            'session' => $session
        ]);
    }
}
