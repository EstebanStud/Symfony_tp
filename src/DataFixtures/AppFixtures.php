<?php

namespace App\DataFixtures;

use App\Entity\Mission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $api = 'https://www.superheroapi.com/api.php/285675680138009';
        $user = new User;
        $user->setName(json_decode(file_get_contents($api . '/527'))->name);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setEmail('este.vdl@gmail.com');
        $user->setPassword($this->userPasswordHasher->hashPassword($user, 'azertyuiop'));
        $manager->persist($user);
        $array = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = new User;
            $user->setName(json_decode(file_get_contents($api . '/' . $i))->name);
            $user->setRoles(['ROLE_SUPER_HERO']);
            $user->setEmail('hereos' . $i . '@gmail.com');
            $user->setPassword($this->userPasswordHasher->hashPassword($user, 'azertyuiop'));
            $manager->persist($user);
            array_push($array, $user);
        }
        $priority = ['weak', 'medium', 'High'];
        $statut = ['To Do', 'In progress', 'Done'];
        for ($i = 1; $i <= 5; $i++) {
            $mission = new Mission;
            $mission->setName('Mission' . $i);
            $mission->setDescription('Description' . $i);
            $mission->setPriority($priority[array_rand($priority)]);
            $mission->setDate(new \DateTime());
            $mission->setStatut($statut[array_rand($statut)]);
            $mission->addHero($array[$i]);
            $manager->persist($mission);

        }

        $manager->flush();
    }
}
