<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class PingResponse
{
    /**
     * @var string
     */
    private $omsId;

    public function __construct(string $omsId)
    {
        $this->omsId = $omsId;
    }

    public function getOmsId(): string
    {
        return $this->omsId;
    }
}