<?php

/**
 * This file contains FormatLinks class for formatting links data
 */

namespace App\Services\Format;

use Symfony\Component\HttpFoundation\Request;

/**
 * FormatLinks class is a service class for formatting links data into desired format.
 */
class FormatLinks
{
    
    /**
     * Formats links into an array with desired data format
     *
     * @param  mixed $pagination
     * @param  array $parameters
     * @param  Request $request
     * @return void
     */
    public function toArray($pagination, array $parameters, Request $request)
    {
        /**
         * Get base link data
         */
        $data = $this->baseUrl($parameters, $request);

        return [
            'prev' => $this->prevUrl($data, $parameters),
            'next' => $this->nextUrl($data, $parameters, $pagination),
            'self' => $this->selfUrl($data, $parameters)
        ];
    }
    
    /**
     * Helper methods for creating links
     */

    /**
     * Data to create base link
     *
     * @param  array $parameters
     * @param  Request $request
     * @return array
     */
    private function baseUrl(array $parameters, Request $request):array
    {
        /**
         * Base url part
         */
        $url = explode('?',$request->getUri());

        /**
         * GET parameters part
         */
        $route = '';
        foreach ($parameters as $key => $value) {
            if  ($key == 'page') {
                continue;
            }
            $route .= "&".$key.'='.$value;
        }

        return [$url[0], $route];
    }
    
    /**
     * Format for previous link
     *
     * @param  array $data
     * @param  array $parameters
     * @return null|string
     */
    private function prevUrl(array $data, array $parameters)
    {
        if ($parameters['page'] != 1) {
            return $data[0] . '?page=' . ($parameters['page'] - 1) . $data[1];
        }
        
        return null;
    }
    
    /**
     * Format for next link
     *
     * @param  array $data
     * @param  array $parameters
     * @param  mixed $pagination
     * @return null|string
     */
    private function nextUrl(array $data, array $parameters, $pagination)
    {
        if ($parameters['page'] < ceil($pagination->getTotalItemCount()/$parameters['per_page'])) {
            return ($data[0] . '?page=' . ($parameters['page'] + 1) . $data[1]);
        }

        return null;
    }
    
    /**
     * Format for self link
     *
     * @param  array $data
     * @param  array $parameters
     * @return null|string
     */
    private function selfUrl(array $data, array $parameters)
    {
        return $data[0] . '?page=' . $parameters['page'] . $data[1];
    }
}