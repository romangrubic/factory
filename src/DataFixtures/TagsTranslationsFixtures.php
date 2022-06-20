<?php

/**
 * This file contains fixtures for tags_translations table
 */

namespace App\DataFixtures;

use App\Entity\TagsTranslations;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\{ORM\EntityManagerInterface,
    Persistence\ObjectManager};
use Faker\Factory;

/**
 * TagsTranslationsFixtures is a fixture class for tags_translations table
 */
class TagsTranslationsFixtures extends Fixture
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
     * Loads fixtures for tags_translation table
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
        $tagsArray = $this->em->getRepository("App\Entity\Tags")->findAll();

        /**
         * Adds translations for each tag based on how many languages in languages table
         */
        foreach ($tagsArray as $tag) {
            foreach ($languageArray as $lang) {
                $tagsTranslation = new TagsTranslations();
                $tagsTranslation->setTagsId($tag);
                $tagsTranslation->setLocale($lang->getCode());
                $tagsTranslation->setTitle('Lang :' . $lang->getCode() . ' - TagId:' . $tag->getId() . ' - ' . $faker->text(50));

                $manager->persist($tagsTranslation);
            }
        }

        $manager->flush();
    }
}
