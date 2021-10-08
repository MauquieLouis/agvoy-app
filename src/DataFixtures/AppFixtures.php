<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Region;
use App\Entity\Room;
// use Faker;
use Faker\Factory;
use App\Repository\RoomRepository;
use App\Repository\RegionRepository;
use App\Entity\Owner;

class AppFixtures extends Fixture
{
    public const IDF_REGION_REFERENCE = 'idf-region';
    private $tableRegions = array();
    private $tableOwner = array();
    private static function RegionDataGenerator()
    {
        yield["FR","Haut-de-France", "C'est haut ici"];
        yield["FR","Occitanie", "C'est le Ter-Ter"];
        yield["FR","Nouvelle-Aquitaine", "L'océan les reufs"];
        yield["FR","Pays de la loire", "Beaucoup de loutres par là"];
        yield["FR","Auvergne-Rhône-Alpes", "On ne sait pas ce qu'il y à la bas"];
        yield["FR","Provence-Alpes-Côte d'Azur", "C'est l'été, le soleil, les vacances, le Pastis !"];
        yield["FR","Grand Est", "La saucisse"];
        yield["FR","Breton", "Ils ont des chapeaux ronds, vive les bretons, ils ont des chapeaux verts, vive les per..."];
        yield["FR","Bourgogne-Franche-Comté", "Je connais pas, mais ça sent le fromage"];
        yield["FR","Centre-Val de Loire", "Je sais pas désolé"];
        yield["FR","Corse", "On y vas pas !"];
        yield["ES","Huesca", "Les canyons"];
        yield["ES","Madrid", "dride Ma"];
        yield["ES","Barcelone", "Oupsssss"];
    }
    
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        //Ajout d'une région
        $region = new Region();
        $region->setCountry("FR");
        $region->setName("Ile de France");
        $region->setPresentation("C'est pas la capitale . ah si.");
        $manager->persist($region);
        
        $itterator = 0;
        foreach(self::RegionDataGenerator() as [$country,$name,$presentation]){
            $region = new Region();
            $region->setCountry($country);
            $region->setName($name);
            $region->setPresentation($presentation);
            $itterator++;
            $this->tableRegions[$itterator] = $name;
            $manager->persist($region);
        }
//         print($this->tableRegions[5]);
        
        $manager->flush();
        
        $itterator = 0;
        for($i=0; $i<10; $i++){
            $owner = new Owner();
            $owner->setAddress($faker->address);
            $owner->setCountry("FR");
            $owner->setFamilyName($faker->firstName);
            $owner->setFirstname($faker->lastName);
            $itterator++;
            $this->tableOwner[$itterator] = $owner->getFamilyName();
            $manager->persist($owner);
        }
        
        $manager->flush();
        
        // Une fois l'instance de Region sauvée en base de données,
        // elle dispose d'un identifiant généré par Doctrine, et peut
        // donc être sauvegardée comme future référence.
        $this->addReference(self::IDF_REGION_REFERENCE, $region);
        
        $regionRepo = $manager->getRepository(Region::class);
        $ownerRepo = $manager->getRepository(Owner::class);
        // ...
        //Génération de 20 Rooms
        for($i=0; $i<20; $i++){
            $room = new Room();
            $room->setSummary($faker->words(15,true));
            $room->setCapacity($faker->numberBetween(2,16));
            $room->setSuperficy($faker->numberBetween(80,350));
            $room->setPrice($faker->numberBetween(900,15000));
            $room->setAddress($faker->address);
            $room->addRegion($regionRepo->findOneBy([ 'name' => $this->tableRegions[$faker->numberBetween(1,14)]]));
            $room->setImage('img'.($i+1).'.PNG');
            $room->setOwner($ownerRepo->findOneBy(['familyName' => $this->tableOwner[$faker->numberBetween(1,10)]]));
            $manager->persist($room);
        }
        
//         $room = new Room();
//         $room->setSummary("Beau poulailler ancien à Évry");
//         $room->setDescription("très joli espace sur paille");
//         $room->setCapacity(2);
//         $room->setSuperficy(9);
//         $room->setAddress('Evry ghetto');
        //$room->addRegion($region);
        // On peut plutôt faire une référence explicite à la référence
        // enregistrée précédamment, ce qui permet d'éviter de se
        // tromper d'instance de Region :
//         $room->addRegion($this->getReference(self::IDF_REGION_REFERENCE));
//         $manager->persist($room);
        
        //AJout de owners        
        $manager->flush();
    }
}
