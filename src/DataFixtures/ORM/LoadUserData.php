<?php //src/DataFixtures/ORM/LoadUserData.php

namespace App\DataFixtures\ORM;

use App\Entity\Objet\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUserData extends Fixture
{    private $passwordEncoder;
 
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
 
    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$fullname, $username, $password, $email, $roles]) {
            $user = new User();
            $user->setFullName($fullname);
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);
 
            $manager->persist($user);
            $this->addReference($username, $user);
        }
 
        $manager->flush();
    }
 
    private function getUserData(): array
    {
        return [
            // $userData = [$fullname, $username, $password, $email, $roles];
            ['', 'superadmin', 'plokiju', 'p.chantois@ville-pantin.fr', ['ROLE_ADMIN']],
            ['', 'admin', 'ppi_admin', 'j.lavidange@ville-pantin.fr', ['ROLE_ADMIN']],
        ];
    }

    public function getOrder()
    {
        return 1;
    }
}