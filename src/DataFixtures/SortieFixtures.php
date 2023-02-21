<?php

namespace App\DataFixtures;

use App\Entity\Sortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SortieFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $baladeNantaise = new Sortie();
        $baladeNantaise->setNom('Balade Nantaise');

        $baladeNantaise->setDateHeureDebut(new \DateTime('2023-02-24 13:30:00'));
        $baladeNantaise->setDuree('240');
        $baladeNantaise->setDateLimiteInscription(new \DateTime('2023-02-20 13:30:00'));
        $baladeNantaise->setNbInscriptionsMax('10');
        $baladeNantaise->setInfosSortie('Une balade à Nantes sur l Ile de Nantes');
        $baladeNantaise->setEtat($this->getReference('etat-cloturee'));
        $baladeNantaise->setOrganisateur($this->getReference('yann'));
        $baladeNantaise->setLieu($this->getReference('ileDeNantes'));
        $baladeNantaise->setCampus($this->getReference('campus-quimper'));
        $this->addReference('baladeNantaise', $baladeNantaise);
        $manager->persist($baladeNantaise);


        $sortiePiscine = new Sortie();
        $sortiePiscine->setNom('Sortie à la piscine de Cholet');
        $sortiePiscine->setDateHeureDebut(new \DateTime('2023-03-22 13:30:00'));
        $sortiePiscine->setDuree('90');
        $sortiePiscine->setDateLimiteInscription(new \DateTime('2023-03-20 13:30:00'));
        $sortiePiscine->setNbInscriptionsMax('30');
        $sortiePiscine->setInfosSortie('Sortie organisée à la piscine de Cholet, Go faire un petit plouf');
        $sortiePiscine->setEtat($this->getReference('etat-ouverte'));
        $sortiePiscine->setOrganisateur($this->getReference('yann'));
        $sortiePiscine->addParticipant($this->getReference('sarah'));
        $sortiePiscine->setLieu($this->getReference('piscine'));
        $sortiePiscine->setCampus($this->getReference('campus-quimper'));
        $this->addReference('sortiePiscine', $sortiePiscine);
        $manager->persist($sortiePiscine);

        $saintEmilion = new Sortie();
        $saintEmilion->setNom('A la découverte des vignobles bordelais');
        $saintEmilion->setDateHeureDebut(new \DateTime('2022-03-22 13:30:00'));
        $saintEmilion->setDuree('360');
        $saintEmilion->setDateLimiteInscription(new \DateTime('2022-03-20 13:30:00'));
        $saintEmilion->setNbInscriptionsMax('40');
        $saintEmilion->setInfosSortie('Demie journée dans les vignobles bordelais');
        $saintEmilion->setEtat($this->getReference('etat-passee'));
        $saintEmilion->setOrganisateur($this->getReference('sarah'));
        $saintEmilion->setLieu($this->getReference('vignoble'));
        $saintEmilion->setCampus($this->getReference('campus-niort'));
        $this->addReference('saintEmilion', $saintEmilion);
        $manager->persist($saintEmilion);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            VilleFixtures::class,
            LieuFixtures::class,
            ParticipantFixtures::class,
        ];
    }
}

