<?php

namespace App\DataFixtures;

use App\Entity\Order;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;



class OrderFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Create Order for user
        $order = new Order();
        $order->setAmount(50);
        $order->setStatus("Effectué");
        $order->setUser($this->getReference('USER') );
        $order->setCreatedAt( new \DateTime() );
        $manager->persist($order);

        $order1 = new Order();
        $order1->setAmount(500);
        $order1->setStatus("Effectué");
        $order1->setUser($this->getReference('USER') );
        $order1->setCreatedAt( new \DateTime() );
        $manager->persist($order1);
        $manager->flush();
    }

    // DependentFixtureInterface :  Load UserFixtures before OrderFixtures
    public function getDependencies()
    {
        return array(
            UserFixtures::class
        );
    }
}
