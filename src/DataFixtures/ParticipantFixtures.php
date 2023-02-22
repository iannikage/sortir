<?php

namespace App\DataFixtures;

use App\Entity\Participant;
use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ParticipantFixtures extends Fixture implements DependentFixtureInterface

{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $yann = new Participant();
        $yann->setNom('Lesieur');
        $yann->setPseudo('yanou');
        $yann->setPrenom('Yann');
        $yann->setTelephone('0656664554');
        $yann->setEmail('yann.lesieur@eni-ecole.fr');
        $yann->setPassword($this->hasher->hashPassword($yann, '123A'));
        $yann->setRoles(['ROLE_ADMIN']);
        $yann->setCampus($this->getReference('campus-quimper'));
        $yann->setActif(true);
        $this->addReference('yann', $yann);

        $manager->persist($yann);


        $sarah = new Participant();
        $sarah->setNom('Dozeville');
        $sarah->setPseudo('Sarahdoz');
        $sarah->setPrenom('Sarah');
        $sarah->setTelephone('0656664590');
        $sarah->setEmail('dozeville.sarah@eni-ecole.fr');
        $sarah->setPassword($this->hasher->hashPassword($sarah, '123B'));
        $sarah->setRoles(['ROLE_USER']);
        $sarah->setCampus($this->getReference('campus-quimper'));
        $sarah->setActif(true);
        $this->addReference('sarah', $sarah);

        $manager->persist($sarah);



        $adele = new Participant();
        $adele->setNom('Colin');
        $adele->setPrenom('Adele');
        $adele->setPseudo('Adele35');
        $adele->setTelephone('0656660000');
        $adele->setEmail('colin.adele@eni-ecole.fr');
        $adele->setPassword($this->hasher->hashPassword($adele, '123C'));
        $adele->setRoles(['ROLE_USER']);
        $adele->setCampus($this->getReference('campus-niort'));
        $adele->setActif(true);
        $this->addReference('adele', $adele);

        $manager->persist($adele);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampusFixtures::class
        ];
    }

}
