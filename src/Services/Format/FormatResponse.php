<?php

/**
 * This file contains FormatResponse class for formatting data into desired response
 */

namespace App\Services\Format;

use App\Services\Format\{FormatData,
    FormatMeta};

/**
 * FormatResponse is a format service class for formatting data
 */
class FormatResponse
{
    private FormatData $formatData;
    private FormatMeta $formatMeta;
    
    /**
     * __construct
     *
     * @param  FormatData $formatData
     * @return void
     */
    public function __construct(FormatData $formatData,
                                FormatMeta $formatMeta )
    {
        $this->formatData = $formatData;
        $this->formatMeta = $formatMeta;
    }
    
    public function formatResponse($parameters, $pagination)
    {
        return [
            'meta' => $this->formatMeta->toArray($pagination, $parameters),
            'data' => $this->formatData->toArray($pagination->getItems(), $parameters),
            'links' => 'links'
        ];
    }
}