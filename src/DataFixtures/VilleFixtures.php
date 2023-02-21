<?php

namespace App\DataFixtures;

use App\Entity\Ville;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class VilleFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $villeNantes = new Ville();
        $villeNantes->setNom('Nantes');
        $villeNantes->setCodePostal('44000');
        $this->addReference('ville-Nantes', $villeNantes);
        $manager->persist($villeNantes);

        $villeCholet = new Ville();
        $villeCholet->setNom('Cholet');
        $villeCholet->setCodePostal('49300');
        $this->addReference('ville-Cholet', $villeCholet);
        $manager->persist($villeCholet);

        $villeBordeaux = new Ville();
        $villeBordeaux->setNom('Bordeaux');
        $villeBordeaux->setCodePostal('33000');
        $this->addReference('ville-Bordeaux', $villeBordeaux);
        $manager->persist($villeBordeaux);

        $manager->flush();
    }
}