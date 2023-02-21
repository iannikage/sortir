<?php

namespace App\DataFixtures;

use App\Entity\Etat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EtatFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $etat = [
            'etat-creee' => 'Créée',
            'etat-ouverte' => 'Ouverte',
            'etat-cloturee' => 'Cloturée',
            'etat-encours' => 'Activité en cours',
            'etat-passee' => 'Passée',
            'etat-annulee' => 'Annulée',

        ];

        foreach ($etat as $key => $etatLibelle) {
            $etat = new Etat();
            $etat->setLibelle($etatLibelle);
            $manager->persist($etat);
            $this->addReference($key, $etat);
        }

        $manager->flush();
    }

}
