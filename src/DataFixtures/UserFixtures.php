<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // Create Yohann User
        $yohann = new User();
        $yohann->setEmail('yohanndurand76@gmail.com');
        $yohann->setPassword($this->passwordEncoder->encodePassword($yohann,'dev'));
        $yohann->setRoles(["ROLE_ADMIN"]);
        $manager->persist($yohann);

        // Create Yohann User
        $sacha = new User();
        $sacha->setEmail('sacha6623@gmail.com');
        $sacha->setPassword($this->passwordEncoder->encodePassword($sacha,'000000'));
        $sacha->setRoles(["ROLE_ADMIN"]);
        $manager->persist($sacha);

        $manager->flush();

    }
}
