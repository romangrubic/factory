<?php

/**
 * This file contains FormatData class for formatting meals data
 */

namespace App\Services\Format;

/**
 * FormatData class is a service class for formatting meals data into desired format.
 * Contains one main method toArray() and three helper methods for category, tags and ingredients data
 */
class FormatData
{    
    /**
     * Main method
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
                'description' => '',
                'category' => $this->category($meal, $parameters)
            ];

            /**
             * Correct language for meal title and description
             */
            foreach ($meal->getMealsTranslations() as $mt) {
                if ($parameters['lang'] == $mt->getLocale()) {
                    $mealData['title'] = $mt->getTitle();
                    $mealData['description'] = $mt->getDescription();
                }
            }

            /**
             * Guard for parameter['with'].
             * If there is no parameter 'with', stop.
             */
            if (!isset($parameters['with'])) {
                $mealsArray[] = $mealData;
                continue;
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

            /**
             * If 'with' parameter has 'ingredients', show tags data
             */
            if (str_contains($parameters['with'], 'ingredients')) {
                $ingredientsArray = $this->ingredients($meal, $parameters);
                if ($ingredientsArray) {
                    $mealData['ingredients'] = $ingredientsArray;
                }
            }

            $mealsArray[] = $mealData;
        }
        
        return $mealsArray;
    }
    
    /**
     * 
     * Helper methods for category, tags and ingredients data
     * 
     */

    /**
     * Sets category field in meal
     *
     * @param  object $meal
     * @param  array $parameters
     * @return mixed
     */
    private function category(object $meal, array $parameters)
    {  
        /**
         * If 'with' parameter has 'category' then show all data, else just id or null
         */
        if (isset($parameters['with']) && str_contains($parameters['with'], 'category')) {
            if ($meal->getCategoryId() != null) {
                foreach ($meal->getCategoryId()->getCategoriesTranslations() as $ct) {
                    if ($parameters['lang'] == $ct->getLocale()) {
                        $translation = $ct->getTitle();
                    };
                }
    
                return [
                    'id' => $meal->getCategoryId()->getId(),
                    'title' => $translation,
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
    private function tags(object $meal, array $parameters): array
    {
        $tagArray = [];

        foreach ($meal->getTags() as $item) {
            foreach ($item->getTagsTranslations() as $tt) {
                if ($parameters['lang'] == $tt->getLocale()) {
                    $translation = $tt->getTitle();
                };
            }
            
            $tagArray[] = [
                'id' => $item->getId(),
                'title' => $translation,
                'slug' => $item->getSlug()
            ];
        }

        return $tagArray;
    }

    /**
     * Returns ingredient data
     *
     * @param  object $meal
     * @param  array $parameters
     * @return array
     */
    private function ingredients(object $meal, array $parameters): array
    {
        $ingredientArray = [];

        foreach ($meal->getIngredients() as $item) {
            foreach ($item->getIngredientsTranslations() as $it) {
                if ($parameters['lang'] == $it->getLocale()) {
                    $translation = $it->getTitle();
                };
            }
            
            $ingredientArray[] = [
                'id' => $item->getId(),
                'title' => $translation,
                'slug' => $item->getSlug()
            ];
        }

        return $ingredientArray;
    }
}