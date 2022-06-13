<?php

/**
 * This file contains fixtures for ingredients table
 */

namespace App\DataFixtures;

use App\Entity\Ingredients;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * IngredientsFixtures is a fixture class for ingredients table
 */
class IngredientsFixtures extends Fixture
{    
    /**
     * Loads fixtures for ingredients table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $count = 100;

        for ($i = 1; $i <= $count; $i++) {
            $ingredient = new Ingredients();
            $ingredient->setSlug('ingredients-'.$i);

            $manager->persist($ingredient);
        }

        $manager->flush();
    }
}
