<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User();
        $user->setPrenom('Tristan')
            ->setNom('Fernandez')
            ->setAge(33)
            ->setUsername('Nh4ru')
            ->setEmail('tristan@dwwm.com')
            ->setPassword($this->hasher->hashPassword($user, ('(Bass-Pearl1989)'))) // Nous devons hasher le password
            ->setRoles(["ROLE_ADMIN"])
            ->setAdresse('48 rue des Mimosas')
            ->setZipCode('26000')
            ->setVille('Valence');

        $manager->persist($user);
        $manager->flush();
    }
}