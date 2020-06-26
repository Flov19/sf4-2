<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * Dans la majorité des classes, on peut récupérer des services par autowiring
     * uniquement dans le constructeur
     */
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    /**
     * UserFixtures constructor.
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        // Création de 10 utilisateurs classiques
        for ($i=0;$i<10;$i++){
            $user = new User();
            //Création du hash du mot de passe
            $hash = $this->passwordEncoder->encodePassword($user, 'user' . $i);

            $user
                ->setEmail('user' . $i . '@mail.org')
                ->setPassword($hash)
            ;

            $manager->persist($user);
        }


        //Création de 3 administrateurs
        //email: admin0@mail.org
        //mdp: admin0
        //rôles: ROLE_ADMIN

        for ($i=0; $i<3;$i++){
            $admin = new User();
            $hash = $this->passwordEncoder->encodePassword($admin, 'admin' . $i);

            $admin
                ->setEmail('admin' . $i . '@mail.org')
                ->setPassword($hash)
                ->setRoles(['ROLE_ADMIN'])
                ;

            $manager->persist($admin);
    }

       $manager->flush();
    }
}
