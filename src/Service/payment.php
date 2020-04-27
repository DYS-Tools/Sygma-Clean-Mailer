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


    public function __construct(EntityManagerInterface $entityManager, $secretStripeKeyTest)
    {
        $this->entityManager = $entityManager;
        $this->secretStripeKeyTest = $secretStripeKeyTest;
    }

    public function getStripeSecretCredentials(){
        //return public key
        return $this->secretStripeKeyTest;
    }



    public function makePayment($number)
    {
        //dump($this->secretStripeKeyTest);
        Stripe::setApiKey($this->secretStripeKeyTest);
        dump($number);

        /*
        $token  = $_POST['stripeToken'];
        $email  = $_POST['stripeEmail'];

        $customer = Stripe::create(array(
            'email' => $email,
            'source'  => $token
        ));

        $charge = Stripe::create(array(
            'customer' => $customer->id,
            'amount'   => $number,
            'currency' => 'eur',
            'description' => 'Discover France Guide by Erasmus of Paris',
            'receipt_email' => $email
        ));

        echo '<h1>Payment accepted!</h1>';
        */


        return true;

    }

}