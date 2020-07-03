<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // Instanciation de Faker
        $faker = Factory::create('fr_FR');

        // Générer 50 produits
        for($i=0; $i<50; $i++){
            $product = new Product();
            $product
                ->setName($faker->sentence(3))
                ->setDescription($faker->optional()->realText())
                ->setPrice($faker->numberBetween(1000, 35000))
                ->setCreatedAt($faker->dateTimeBetween('-6 month'))
            ;

            // Récupération aléatoire d'une catégorie par une référence
            $categoryReference = 'category_' . $faker->numberBetween(0, 2);
            $category = $this->getReference($categoryReference);

            $product->setCategory($category);

            $manager->persist($product);
        }

        $manager->flush();
    }

    /**
     * Liste des classes de fixtures qui doivent être chargé avant celle-ci
     */

    public function getDependencies()
    {
        return [
            CategoryFixtures::class
        ];
    }
}
