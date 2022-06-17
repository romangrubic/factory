<?php

/**
 * This file contains FormatResponse class for formatting data into desired response
 */

namespace App\Services\Format;

use App\Services\Format\{FormatData,
    FormatMeta,
    FormatLinks};

/**
 * FormatResponse is a format service class for formatting data
 */
class FormatResponse
{
    /**
     * Setting properties
     */
    private FormatData $formatData;
    private FormatMeta $formatMeta;
    private FormatLinks $formatLinks;
    
    /**
     * __construct
     *
     * @param  FormatData $formatData
     * @param  FormatMeta $formatMeta
     * @param  FormatLinks $formatLinks
     * @return void
     */
    public function __construct(FormatData $formatData,
                                FormatMeta $formatMeta,
                                FormatLinks $formatLinks)
    {
        $this->formatData = $formatData;
        $this->formatMeta = $formatMeta;
        $this->formatLinks = $formatLinks;
    }
    
    public function formatResponse($parameters, $pagination, $request)
    {
        return [
            'meta' => $this->formatMeta->toArray($pagination, $parameters),
            'data' => $this->formatData->toArray($pagination->getItems(), $parameters),
            'links' => $this->formatLinks->toArray($pagination, $parameters, $request)
        ];
    }
}