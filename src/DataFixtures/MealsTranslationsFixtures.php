<?php
/**
 * This file contains fixtures for meals_translations table
 */
namespace App\DataFixtures;

use App\Entity\MealsTranslations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * MealsTranslationsFixtures is a fixture class for meals_translations table
 */
class MealsTranslationsFixtures extends Fixture
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
     * Loads fixtures for meals_translation table
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
        $mealArray = $this->em->getRepository("App\Entity\Meals")->findAll();

        /**
        * Adds translations for each meal based on how many languages in languages table
        */
        foreach ($mealArray as $meal) {
            foreach ($languageArray as $lang) {
                $mealTranslation = new MealsTranslations();
                $mealTranslation->setMeals($meal);
                $mealTranslation->setLocale($lang->getCode());
                $mealTranslation->setTitle('Lang :' . $lang->getCode() . ' - MealId:' . $meal->getId() . ' - ' . $faker->text(50));
                $mealTranslation->setDescription('Lang :' . $lang->getCode() . ' - MealId:' . $meal->getId() . ' - ' . $faker->text(50));

                $manager->persist($mealTranslation);
            }
        }

        $manager->flush();
    }
}
