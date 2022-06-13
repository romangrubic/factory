<?php

/**
 * This file contains fixtures for meals_ingredients join table
 */

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\{ORM\EntityManagerInterface,
    Persistence\ObjectManager};

/**
 * ZmealsIngredients is a fixture class for meals_ingredients join table
 * Z is added for securing that this fixture goes last (after meals and ingredients fixtures)
 */
class ZmealsIngredientsFixtures extends Fixture
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
     * Loads fixtures for meals_ingredients join table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        $mealsArray = $this->em->getRepository("App\Entity\Meals")->findAll();
        $ingredientsArray = $this->em->getRepository("App\Entity\Ingredients")->findAll();

        /**
         * For each meal, add random number of ingredients
         */
        foreach ($mealsArray as $meal) {
            $random = rand(1,4);

            for ($i = 1; $i <= $random; $i++) {
                $meal->addIngredient($ingredientsArray[array_rand($ingredientsArray)]);

                $manager->persist($meal);
            }
        }
        $manager->flush();
    }
}
