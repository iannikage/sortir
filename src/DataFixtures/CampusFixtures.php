<?php

namespace App\DataFixtures;

use App\Entity\Campus;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CampusFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $campus = [
            'campus-quimper' => 'Quimper',
            'campus-niort' => 'Niort',
        ];

        foreach ($campus as $key => $campusName) {
            $campus = new Campus();
            $campus->setNom($campusName);
            $manager->persist($campus);
            $this->addReference($key, $campus);
        }

        $manager->flush();
    }
}
