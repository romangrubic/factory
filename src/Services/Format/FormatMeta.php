<?php

/**
 * This file contains FormatMeta class for formatting meta data
 */

namespace App\Services\Format;

/**
 * FormatMeta class is a service class for formatting meta data into desired format.
 */
class FormatMeta
{    
    /**
     * Formats meta into an array with desired data format
     *
     * @param  object $pagination
     * @param  array $parameters
     * @return array
     */
    public function toArray(object $pagination, array $parameters): array
    {
        return [
            'currentPage' => $pagination->getCurrentPageNumber(),
            'totalItems' => $pagination->getTotalItemCount(),
            'itemsPerPage' => $parameters['per_page'],
            'totalPages' => ($pagination->getTotalItemCount()/$parameters['per_page'])
        ];
    }
}