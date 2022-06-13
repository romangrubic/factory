<?php

/**
* This file contains fixtures for meals table.
*/

namespace App\DataFixtures;

use App\Entity\Meals;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * MealsFixtures is a fixture class for meals table
 */
class MealsFixtures extends Fixture
{    
    /**
     * Loads fixtures for meals table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $count = 20;

        for ($i = 1; $i <= $count; $i++) {
            $meal = new Meals();
            $meal->setCreatedAt(new \DateTime('now'));
            $meal->setUpdatedAt(new \DateTime('now'));

            $manager->persist($meal);
        }

        $manager->flush();
    }
}
