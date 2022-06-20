<?php

/**
 * This file contains fixtures for ingredients_translations table
 */

namespace App\DataFixtures;

use App\Entity\IngredientsTranslations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * IngredientsTranslationsFixtures is a fixture class for ingredients_translations table
 */
class IngredientsTranslationsFixtures extends Fixture
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
     * Loads fixtures for ingredients_translations table
     *
     * @param  ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void
    {
        /**
         * Faker class
         */
        $faker = Factory::create();

        $languageArray = $this->em->getRepository("App\Entity\Languages")->findAll();
        $ingredientsArray = $this->em->getRepository("App\Entity\Ingredients")->findAll();

        /**
         * Adds translations for each ingredient based on how many languages in languages table
         */
        foreach ($ingredientsArray as $ingredient) {
            foreach ($languageArray as $lang) {
                $ingredientTranslation = new IngredientsTranslations();
                $ingredientTranslation->setIngredients($ingredient);
                $ingredientTranslation->setLocale($lang->getCode());
                $ingredientTranslation->setTitle('Lang :' . $lang->getCode() . ' - IngredientId:' . $ingredient->getId() . ' - ' . $faker->text(50));

                $manager->persist($ingredientTranslation);
            }
        }

        $manager->flush();
    }
}
