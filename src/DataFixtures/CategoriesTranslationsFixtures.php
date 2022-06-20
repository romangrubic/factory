<?php

/**
 *  This file contains fixtures for categories_translations table
 */
namespace App\DataFixtures;

use App\Entity\CategoriesTranslations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

/**
 * CategoriesTranslationsFixtures is a fixture class for categories_translations table
 */
class CategoriesTranslationsFixtures extends Fixture
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
     * Loads fixtures for categories_translations table
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
        $categoryArray = $this->em->getRepository("App\Entity\Categories")->findAll();

        /**
         * Adds translations for each category based on how many languages in languages table
         */
        foreach ($categoryArray as $category) {
            foreach ($languageArray as $lang) {
                $categoriesTranslation = new CategoriesTranslations();
                $categoriesTranslation->setCategoriesId($category);
                $categoriesTranslation->setLocale($lang->getCode());
                $categoriesTranslation->setTitle('Lang :' . $lang->getCode() . ' - CategoryId:' . $category->getId() . ' - ' . $faker->text(50));

                $manager->persist($categoriesTranslation);
            }
        }

        $manager->flush();
    }
}
