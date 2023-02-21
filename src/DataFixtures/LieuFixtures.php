<?php

namespace App\DataFixtures;

use App\Entity\Lieu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LieuFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $ileDeNantes = new Lieu();
        $ileDeNantes->setNom('Ile de Nantes');
        $ileDeNantes->setRue('Rue de Nantes');
        $ileDeNantes->setLatitude(null);
        $ileDeNantes->setLongitude(null);
        $ileDeNantes->setVille($this->getReference('ville-Nantes'));
        $this->addReference('ileDeNantes', $ileDeNantes);
        $manager->persist($ileDeNantes);


        $piscine = new Lieu();
        $piscine->setNom('Piscine');
        $piscine->setRue('Avenue Anatole Manceau');
        $piscine->setLatitude(null);
        $piscine->setLongitude(null);
        $piscine->setVille($this->getReference('ville-Cholet'));
        $this->addReference('piscine', $piscine);
        $manager->persist($piscine);


        $vignoble = new Lieu();
        $vignoble->setNom('Vignoble');
        $vignoble->setRue('Saint Emilion');
        $vignoble->setLatitude(null);
        $vignoble->setLongitude(null);
        $vignoble->setVille($this->getReference('ville-Bordeaux'));
        $this->addReference('vignoble', $vignoble);
        $manager->persist($vignoble);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
        ];
    }
}
