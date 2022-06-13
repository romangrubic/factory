<?php

/**
 * This file contains fixtures for tags table.
 */

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * TagsFixtures is a fixture class for tags table
 */
class TagsFixtures extends Fixture
{    
    /**
     * Loads fixtures for tags table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
       $count = 100;

       for ($i = 1; $i <= $count; $i++) {
            $tags = new Tags();
            $tags->setSlug('tag-'.$i);

            $manager->persist($tags);
       }

       $manager->flush();
    }
}
