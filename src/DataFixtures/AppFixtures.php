<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Modele;
use App\Entity\Voiture;
use App\Entity\Locateur;
use App\Entity\Location;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Factory::create();

        $locations = [];

        for ($i = 0; $i < 50; $i++) {
            $location = new Location();
            $location->setDateLocation(new \DateTime());
            $location->setNbJrLocation($faker->numberBetween($min = 1, $max = 30));
            $location->setPrixLocation($faker->numberBetween($min = 150, $max = 1600));
            $manager->persist($location);
            $locations[] = $location;
        }

        $voitures = [];

        for ($i = 0; $i < 50; $i++) {

            $voiture = new Voiture();

            $voiture->setNom($faker->name);

            $voiture->setImage($faker->imageUrl());

            $voiture->setNbKm($faker->numberBetween());

            $voiture->setCreatAt(new \DateTimeImmutable());

            $manager->persist($voiture);

            $voitures[] = $voiture;
        }

        $locateurs = [];

        for ($i = 0; $i < 50; $i++) {
            $locateur = new Locateur();
            $locateur->setNom($faker->lastName());
            $locateur->setPrenom($faker->firstName());
            $locateur->setAge($faker->numberBetween($min = 18, $max = 76));
            $locateur->setAdresse($faker->address());
            $locateur->setVoiture($voitures[$faker->numberBetween(0, 14)]);
            $manager->persist($locateur);
            $locateurs[] = $locateur;
        }

        $modeles = [];

        for ($i = 0; $i < 100; $i++) {
            $modele = new Modele();
            $modele->setTypeModele($faker->name());
            $modele->setAnneeModele($faker->numberBetween(1999, 2023));
            $modele->setConso($faker->numberBetween(2, 15));
            $modele->addLocateur($locateurs[$faker->numberBetween(0, 49)]);
            $modele->addLocation($locations[$faker->numberBetween(0, 49)]);
            $manager->persist($modele);
            $modeles[] = $modele;
        }

        $manager->flush();
    }
}