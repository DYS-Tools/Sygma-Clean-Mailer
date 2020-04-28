<?php

namespace App\Controller;

use App\Entity\Order;
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
        //$payment->makePayment(5);

        // Payment Card For Testing : 4242424242424242
        Stripe::setApiKey($payment->getStripeSecretCredentials());

        /*
        if (!$order) {
            //$order = new Order();
        }
        */

        //$form = $this->createForm(PaiementType::class, $order);
     
        //$form->handleRequest($request);
     
        $token =\Stripe\Token::create([
            'card' => [
              'number' => '4000002500000003',
              'exp_month' => 12,
              'exp_year' => 2040,
              'cvc' => 464,
              'name'=> 'Harry Covert',
              'address_country'=>'FR',
              'address_city'=>'Strasbourg'
     
            ]
          ]);
     
         \Stripe\Charge::create([
            'amount' => 9000, //le montant est en centime
            'currency' => 'eur',
            'description' => 'test paye',
            'source' => $token,
            //'customer'=> $customer
            ]);


        return $this->render('order/order.html.twig', [
            'stripe_secret_key' => $payment->getStripeSecretCredentials(),
            'stripe_public_key' => $payment->getStripePublicCredentials(),
            //'formPay' ->$form->createView()
        ]);
    }
}
