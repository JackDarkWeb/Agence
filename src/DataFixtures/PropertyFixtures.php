<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class PropertyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        for($i = 1; $i < 8; $i++){
            $property = new Property();
            $property->setTitle(" Mon bien numero $i")
                ->setDescription("Une petite description $i")
                ->setSurface(2*$i)
                ->setRooms($i)
                ->setBedrooms($i)
                ->setFloor($i)
                ->setPrice(5000*$i)
                ->setHeat(1)
                ->setCity("Paris $i")
                ->setAddress("$i Boulevard Gaul")
                ->setSold(0)
                ->setPostalCode("3400$i")
                ->setCreatedAt(new \DateTime());

            $manager->persist($property);
        }

        $manager->flush();
    }
}
