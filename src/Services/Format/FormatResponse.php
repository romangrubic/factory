<?php

/**
 * This file contains FormatResponse class for formatting data into desired response
 */

namespace App\Services\Format;

use App\Services\Format\FormatData;

/**
 * FormatResponse is a format service class for formatting data
 */
class FormatResponse
{
    private FormatData $formatData;
    
    /**
     * __construct
     *
     * @param  FormatData $formatData
     * @return void
     */
    public function __construct(FormatData $formatData )
    {
        $this->formformatDataatItem = $formatData;
    }
    
    public function formatResponse($parameters, $pagination)
    {
        return [
            'meta' => 'meta',
            'data' => $this->formatData->toArray($pagination->getItems(), $parameters),
            'links' => 'links'
        ];
    }
}