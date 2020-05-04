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
        $manager->persist($order);
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
