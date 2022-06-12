<?php

/**
 * This file contains fixtures for languages table
 */

namespace App\DataFixtures;

use App\Entity\Languages;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * LanguagesFixtures is a fixture class for languages table
 */
class LanguagesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /**
         * Add more if needed
         */
        $data = [
            ['language' => 'Hrvatski',
                'code' => 'hr'],
            ['language' => 'English',
                'code' => 'en'],
            ['language' => 'Deutsch',
                'code' => 'de'],
            ['language' => 'Italiana',
                'code' => 'it'],
            ['language' => 'Española',
                'code' => 'es']
        ];

        foreach ($data as $d) {
            $language = new Languages();
            $language->setLanguage($d['language']);
            $language->setCode($d['code']);

            $manager->persist($language);
        }

        $manager->flush();
    }
}
