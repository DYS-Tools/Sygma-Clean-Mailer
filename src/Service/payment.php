<?php
/**
 * Created by PhpStorm.
 * User: sacha
 * Date: 14/04/2020
 * Time: 22:33
 */

namespace App\Service;


use App\Entity\Email;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Stripe\Stripe;

class payment
{

    private $entityManager;
    private $secretStripeKeyTest;
    private $publicStripeKeyTest;


    public function __construct(EntityManagerInterface $entityManager, $secretStripeKeyTest, $publicStripeKeyTest)
    {
        $this->entityManager = $entityManager;
        $this->secretStripeKeyTest = $secretStripeKeyTest;
        $this->publicStripeKeyTest = $publicStripeKeyTest;
    }

    public function getStripeSecretCredentials(){
        //return secret key
        return $this->secretStripeKeyTest;
    }

    public function getStripePublicCredentials(){
        //return public key
        return $this->publicStripeKeyTest;
    }



    public function makePayment($price,$article)
    {
        //dump($this->secretStripeKeyTest);
        Stripe::setApiKey($this->secretStripeKeyTest);
        
        //Convert euro in centim
        $price = $price * 100 ;

        //TODO: Create success and cancel URL and redirect payment
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
              'name' => $article,
              'description' => 'Comfortable cotton t-shirt',
              'images' => ['https://example.com/t-shirt.png'],
              'amount' => $price,
              'currency' => 'eur',
              'quantity' => 1,
            ]],
            'success_url' => 'https://SpeedMailer/sucessURL',
            'cancel_url' => 'https://SpeedMailer/cancelURL',
          ]);

        return $session;

    }

}