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

        // Create Yohann Admin
        $yohann = new User();
        $yohann->setEmail('yohanndurand76@gmail.com');
        $yohann->setPassword($this->passwordEncoder->encodePassword($yohann,'dev'));
        $yohann->setRoles(["ROLE_ADMIN"]);
        $yohann->setMailCredit(1000);
        $manager->persist($yohann);

        // Create Yohann Admin
        $sacha = new User();
        $sacha->setEmail('sacha6623@gmail.com');
        $sacha->setPassword($this->passwordEncoder->encodePassword($sacha,'000000'));
        $sacha->setRoles(["ROLE_ADMIN"]);
        $sacha->setMailCredit(1000);
        $manager->persist($sacha);

        // Create User
        $user = new User();
        $user->setEmail('user@gmail.com');
        $user->setPassword($this->passwordEncoder->encodePassword($user,'dev'));
        $user->setRoles(["ROLE_USER"]);
        $user->setMailCredit(100);
        $manager->persist($user);

        $manager->flush();

    }
}
