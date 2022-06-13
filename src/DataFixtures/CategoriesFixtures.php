<?php

/**
 * This file contains fixtures for categories table.
 */

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * CategoriesFixtures is a fixture class for categories table
 */
class CategoriesFixtures extends Fixture
{    
    /**
     * Loads fixtures for categories table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $count = 20;

        for ($i = 1; $i <= $count; $i++) {
            $category = new Categories();
            $category->setSlug('category-' . $i);

            $manager->persist($category);
        }

        $manager->flush();
    }
}
