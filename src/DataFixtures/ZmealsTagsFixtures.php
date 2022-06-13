<?php

/**
 * This file contains fixtures for meals_tags join table
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\{ORM\EntityManagerInterface,
    Persistence\ObjectManager};

/**
 * ZmealsTagsFixtures is a fixture class for meals_tags join table
 * Z is added for securing that this fixture goes last (after meals and tags fixtures)
 */
class ZmealsTagsFixtures extends Fixture
{
    private EntityManagerInterface $em;
    
    /**
     * __construct
     *
     * @param  EntityManagerInterface $em
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
        
    /**
     * Loads fixtures for meals_tags join table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $mealsArray = $this->em->getRepository("App\Entity\Meals")->findAll();
        $tagsArray = $this->em->getRepository("App\Entity\Tags")->findAll();

        /**
         * For each meal, add random number of tags
         */
        foreach ($mealsArray as $meal) {
            $random = rand(1,4);

            for ($i = 1; $i <= $random; $i++) {
                $meal->addTag($tagsArray[array_rand($tagsArray)]);

                $manager->persist($meal);
            }
        }
        $manager->flush();
    }
}
