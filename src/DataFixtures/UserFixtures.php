<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encode)
    {
        $this->encode=$encode;
    }
    public function load(ObjectManager $manager): void
    {
        foreach ($this->getUserData() as [$name, $email, $password,$api_key, $roles]) {

            $user = new User();

            $user->setName( $name);
            $user->setEmail($email);
            $user->setPassword($this->encode->encodePassword($user,$password));
            $user->setVimeoApiKey($api_key);
            $user->setRoles($roles);
            $manager->persist($user);
        }

        $manager->flush();
    }

    private function getUserData(): array 
    {
        return [
            ['John', 'jw@symf4.loc', 'passw', 'hjd8dehdh',['ROLE_ADMIN']],
            ['John', 'jw2@symf4.loc', 'passw',  'hjd8dehdh', ['ROLE ADMIN']],
        ];
    }
}
