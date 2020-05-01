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


            $form = $this->createForm(PaymentFormType::class);
            $form->handleRequest($request);

            $token =\Stripe\Token::create([
                'card' => [
                'number' => '4242 4242 4242 4242',
                'exp_month' => 12,
                'exp_year' => 2040,
                'cvc' => 464,
                'name'=> 'Harry Covert',
                'address_country'=>'FR',
                'address_city'=>'Strasbourg'
        
                ]
            ]);

           

        return $this->render('order/order.html.twig', [
            'stripe_secret_key' => $payment->getStripeSecretCredentials(),
            'stripe_public_key' => $payment->getStripePublicCredentials(),
            'formPay' => $form->createView()
        ]);
    }

    /**
     * @Route("/pay", name="pay")
     */
    public function pay(payment $payment){

        Stripe::setApiKey($payment->getStripeSecretCredentials());

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'name' => 'A grant Access',
              'description' => 'Your custom designed t-shirt',
              'amount' => 15000,
              'currency' => 'eur',
              'quantity' => 1,
            ]],
            'success_url' => 'https://successStripe',
            'cancel_url' => 'https://cancelStripe',
          ]);

        //dump($task = $form['name']->getData());
                dump('form soumis');
                $number = 500;
                //$payment->makePayment(5);

                // Payment Card For Testing : 4242424242424242
            
                //$data = Charge::retrieve('ch_%');
                $token =\Stripe\Token::create([
                    'card' => [
                    'number' => '4242 4242 4242 4242',
                    'exp_month' => 12,
                    'exp_year' => 2040,
                    'cvc' => 464,
                    'name'=> 'Harry Covert',
                    'address_country'=>'FR',
                    'address_city'=>'Strasbourg'
            
                    ]
                ]);


                \Stripe\Charge::create([
                    'amount' => $number, //le montant est en centime
                    'currency' => 'eur',
                    'description' => 'test paye',
                    'source' => $token,
                    ]);
        
                    $intent = \Stripe\PaymentIntent::create([
                        'amount' => $number, // Le prix doit être transmis en centimes
                        'currency' => 'eur',
                    ]);


        return $this->render('order/stateOfPayment.html.twig', [
            'state' => 'Indisponible'
        ]);
    }
}
