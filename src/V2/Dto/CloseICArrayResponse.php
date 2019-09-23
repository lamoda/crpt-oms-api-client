<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class CloseICArrayResponse
{
    /**
     * @var string
     */
    private $omsId;

    /**
     * @param string $omsId
     */
    public function __construct(string $omsId)
    {
        $this->omsId = $omsId;
    }

    public function getOmsId(): string
    {
        return $this->omsId;
    }
}