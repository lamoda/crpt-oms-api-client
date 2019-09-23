<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class GetICsFromOrderResponse
{
    /**
     * @var string
     */
    private $omsId;
    /**
     * @var string[]
     */
    private $codes;
    /**
     * @var string
     */
    private $blockId;

    public function __construct(string $omsId, array $codes, string $blockId)
    {
        $this->omsId = $omsId;
        $this->codes = $codes;
        $this->blockId = $blockId;
    }

    public function getOmsId(): string
    {
        return $this->omsId;
    }

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return $this->codes;
    }

    public function getBlockId(): string
    {
        return $this->blockId;
    }
}
