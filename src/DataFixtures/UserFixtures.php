<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user1= new User();
        $password1 = $this->encoder->encodePassword($user1, 'iutinfo');
        $user1->setPassword($password1);
        $user1->setName('Jules');
        $user1->setEmail('admin@outlook.fr');
        $user1->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $manager->persist($user1);
        $manager->flush();

        UserFactory::createMany(4); //pour random values
    }
}
