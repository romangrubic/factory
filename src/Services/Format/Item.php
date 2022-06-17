<?php

namespace App\Services\Format;

class Item
{
    public function toArray($data, $parameters)
    {
        $mealsArray = [];

        foreach ($data as $meal) {
            $m = [
                'id' => $meal->getId(),
                'title' => '',
                'category' => $this->category($meal, $parameters)
            ];

            foreach ($meal->getMealsTranslations() as $mt) {
                if ($parameters['lang'] == $mt->getLocale()) {
                    $m['title'] = $mt->getTitle();
                }
                // $meal->setDescription($mt->getDescription());
            }



            // dd($m);
            // dd($meal->getMealsTranslations()[0]->getTitle());
            // if ($meal->getCategoryId() != null) {
            //     dd($meal);
            //     // $meal->setCategoryId($meal->getCategoryId());
            // }
            $mealsArray[] = $m;
        }

        // dd($mealsArray);
        return $mealsArray;
    }

    public function category($meal, $parameters)
    {
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
        } else {
            return null ;
        }
    }
}