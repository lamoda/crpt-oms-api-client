<?php

declare(strict_types=1);

namespace Lamoda\OmsClient\V2\Dto;

final class CreateOrderForEmissionICResponse
{
    /**
     * @var string
     */
    private $omsId;
    /**
     * @var string
     */
    private $orderId;
    /**
     * @var int
     */
    private $expectedCompleteTimestamp;

    public function __construct(string $omsId, string $orderId, int $expectedCompleteTimestamp)
    {
        $this->omsId = $omsId;
        $this->orderId = $orderId;
        $this->expectedCompleteTimestamp = $expectedCompleteTimestamp;
    }

    public function getOmsId(): string
    {
        return $this->omsId;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getExpectedCompleteTimestamp(): int
    {
        return $this->expectedCompleteTimestamp;
    }
}