<?php

/**
 * This file contains Item class for formatting meals data
 */

namespace App\Services\Format;

class Item
{    
    /**
     * Formats meals into an array with desired data format
     *
     * @param  array $data
     * @param  array $parameters
     * @return array
     */
    public function toArray(array $data, array $parameters): array
    {
        $mealsArray = [];

        foreach ($data as $meal) {
            $mealData = [
                'id' => $meal->getId(),
                'title' => '',
                'category' => $this->category($meal, $parameters)
            ];

            /**
             * Correct language for meal title and description
             */
            foreach ($meal->getMealsTranslations() as $mt) {
                if ($parameters['lang'] == $mt->getLocale()) {
                    $mealData['title'] = $mt->getTitle();
                // $meal->setDescription($mt->getDescription());
                }
            }

            /**
             * If 'with' parameter has 'tags', show tags data
             */
            if (str_contains($parameters['with'], 'tags')) {
                $tagArray = $this->tags($meal, $parameters);
                if ($tagArray) {
                    $mealData['tags'] = $tagArray;
                }
            }

            $mealsArray[] = $mealData;
        }
        
        return $mealsArray;
    }
    
    /**
     * Sets category field in meal
     *
     * @param  object $meal
     * @param  array $parameters
     * @return mixed
     */
    public function category(object $meal, array $parameters)
    {  
        /**
         * If 'with' parameter has 'category' then show all data, else just id or null
         */
        if (str_contains($parameters['with'], 'category')) {
            if ($meal->getCategoryId() != null) {
                foreach ($meal->getCategoryId()->getCategoriesTranslations() as $ct) {
                    if ($parameters['lang'] == $ct->getLocale()) {
                        $tran = $ct->getTitle();
                    };
                }
    
                return [
                    'id' => $meal->getCategoryId()->getId(),
                    'title' => $tran,
                    'slug' => $meal->getCategoryId()->getSlug()
                ];
            }
            return null;
        }

        if ($meal->getCategoryId() != null) {  
            return $meal->getCategoryId()->getId();
        }

        return null;
    }
    
    /**
     * Returns tag data
     *
     * @param  object $meal
     * @param  array $parameters
     * @return array
     */
    public function tags(object $meal, array $parameters): array
    {
        $tagArray = [];

        foreach ($meal->getTags() as $item) {
            foreach ($item->getTagsTranslations() as $tt) {
                if ($parameters['lang'] == $tt->getLocale()) {
                    $tran = $tt->getTitle();
                };
            }
            
            $tagArray[] = [
                'id' => $item->getId(),
                'title' => $tran,
                'slug' => $item->getSlug()
            ];
        }

        return $tagArray;
    }
}